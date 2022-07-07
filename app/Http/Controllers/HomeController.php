<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    function index(){
        // Potevo leggere il Json normalmente, ma ho preferito simulare una chiamata API
        $response = Http::get('http://testdm.dv/api/rest.json');
        if ($response->failed() || $response->json()['response'] !== 'success')
            $response->throw();

        $total_travels = $response->json()['data'];
        $trendings = $total_travels;

        // Elimino i viaggi non attivi
        foreach($total_travels as $key => $travel){
            if($travel['isActive'] === false)
                unset($total_travels[$key]);
        }

        // Ordino i viaggi in base alla data di creazione
        usort($total_travels, function($a, $b) {
            $ad = new \DateTime($a['createdAt']);
            $bd = new \DateTime($b['createdAt']);
            return $ad > $bd ? -1 : 1;
        });

        // Ordino i trendings in base al prezzo, se bestTour è null (o bestTour['price'] vengono spinti infondo all'array
        usort($trendings, function($a, $b) {
            if(!empty($a['bestTour']['price']))
                $ap = $a['bestTour']['price'];
            else
                return 1;
            if(!empty($b['bestTour']['price']))
                $bp = $b['bestTour']['price'];
            else
                return -1;
            return $ap < $bp ? -1 : 1;
        });

        // Avrei potuto fare un Helper ma ho incluso la funzione in questa classe per far prima dato il tempo scarso a disposizione
        $travels = $this->format_travels($total_travels, 16);
        $travels = $this->format_travels($trendings, 8, $travels, 'trendings');

        return view('home', [ 'travels' => $travels ]);
    }

    /**
     * Riformatta i dati in base al JSON delle API pronti per la vista
     *
     * @param $travels - Viaggi
     * @param $limit_per_continent - Quanti viaggi al massimo
     * @param $total_array - Array su cui operare - default: []
     * @param string $type - Tipo - viene utilizzato come chiave per l'array di ritorno - detault: 'travels'
     * @return mixed
     * @throws \Exception
     */
    function format_travels($travels, $limit_per_continent, $total_array = [], $type = 'travels'){
        foreach($travels as $travel) {
            $continent_code = $travel[ 'primaryDestination' ][ 'primaryContinent' ][ 'code' ];

            if(
                ( isset($total_array[$continent_code][$type]) && count($total_array[ $continent_code ][$type] ) >= $limit_per_continent ) ||
                is_null($travel['bestTour'])
            )
                continue;

            if(!isset($total_array[$continent_code]['label']))
                $total_array[$continent_code]['label'] = trim($travel[ 'primaryDestination' ][ 'primaryContinent' ][ 'name' ]);

            $id = $travel[ 'id' ];
            $title = trim($travel[ 'title' ]);
            $days = $travel[ 'numberOfDays' ];
            $destination = $travel[ 'destinationLabel' ];

            $now = new \DateTime();
            $created_at = new \DateTime($travel[ 'createdAt' ]);
            $diff = $now->diff($created_at)->format("%a");

            $thumbnails = [];
            if (!empty($travel[ 'thumbnailImage' ][ 'desktop' ][ 'thumbnailUrl' ])) {
                $thumbnails[ 'desktop' ] = [
                    'url' => $travel[ 'thumbnailImage' ][ 'desktop' ][ 'thumbnailUrl' ],
                    'title' => (!empty($travel[ 'thumbnailImage' ][ 'desktop' ][ 'thumbnailUrl' ])) ? $travel[ 'thumbnailImage' ][ 'desktop' ][ 'thumbnailUrl' ] : '',
                    'alt' => (!empty($travel[ 'thumbnailImage' ][ 'desktop' ][ 'altText' ])) ? $travel[ 'thumbnailImage' ][ 'desktop' ][ 'altText' ] : '',
                ];
            }
            if (!empty($travel[ 'thumbnailImage' ][ 'mobile' ][ 'thumbnailUrl' ])) {
                $thumbnails[ 'mobile' ] = [
                    'url' => $travel[ 'thumbnailImage' ][ 'mobile' ][ 'thumbnailUrl' ],
                    'title' => (!empty($travel[ 'thumbnailImage' ][ 'mobile' ][ 'thumbnailUrl' ])) ? $travel[ 'thumbnailImage' ][ 'mobile' ][ 'thumbnailUrl' ] : '',
                    'alt' => (!empty($travel[ 'thumbnailImage' ][ 'mobile' ][ 'altText' ])) ? $travel[ 'thumbnailImage' ][ 'mobile' ][ 'altText' ] : '',
                ];
            }

            $total_array[$continent_code][$type][$id] = [
                'title' => $title,
                'thumbnails' => $thumbnails,
                'days' => $days,
                'diff_days' => $diff,
                'destination' => $destination,
            ];
        }

        return $total_array;
    }
}
