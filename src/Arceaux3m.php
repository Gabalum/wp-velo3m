<?php
/**
 * @package Velo3m
 */
 namespace Velo3m;
 class Arceaux3m
 {
    private static $initiated = false;
    private static $rootDir = '';

    public static function init()
    {
        if ( ! self::$initiated ) {
            $root = dirname(__DIR__, 4);
            $dir = dirname(__DIR__);
            self::$rootDir = str_replace($root, '', $dir);
            self::init_hooks();
        }
    }

    private static function init_hooks()
    {
        self::$initiated = true;
        add_action( 'wp_enqueue_scripts', [self::class, 'enqueueScripts']);
        add_shortcode('arceaux3m', [self::class, 'shortcodeArceaux3m']);
    }

    public static function enqueueScripts()
    {
        wp_enqueue_style( 'leaflet.css','https://unpkg.com/leaflet@1.7.1/dist/leaflet.css');
        wp_enqueue_style( 'leafletMCD.css','https://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/1.5.3/MarkerCluster.Default.min.css');
        wp_enqueue_style( 'leafletMC.css','https://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/1.5.3/MarkerCluster.min.css');
        wp_enqueue_script('leaflet.js', 'https://unpkg.com/leaflet@1.7.1/dist/leaflet.js', false, false, true);
        wp_enqueue_script('leafletMC.js', 'https://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/1.5.3/leaflet.markercluster.js', false, false, true);
        wp_enqueue_script('velo3m_arceaux.js', self::$rootDir.'/assets/arceaux.js',false, false, true);
    }

    public static function shortcodeArceaux3m($atts = [], $content = null, $tag = '')
    {
        $width = '100%';
        $height = '350px';
        $map = 'default';
        if(isset($atts['width'])){
            $x = trim($atts['width']);
            $v = (int)str_replace(['px', '%'], '', $x);
            if(substr($x, -1) == '%'){
                $width = $v.'%';
            }else{
                $width = $v.'px';
            }
        }
        if(isset($atts['height'])){
            $x = trim($atts['height']);
            $v = (int)str_replace(['px', '%'], '', $x);
            if(substr($x, -1) == '%'){
                $height = $v.'%';
            }else{
                $height = $v.'px';
            }
        }
        if(isset($atts['map'])){
            $v = trim($atts['map']);
            if(in_array($v, ['cyclosm', 'default', 'osm'])){
                $map = $v;
            }
        }
        $upDir = wp_upload_dir()['basedir'].'/velo3m';
        if(!file_exists($upDir)){
            wp_mkdir_p($upDir);
        }
        $file = $upDir.'/arceaux.json';
        if(!file_exists($file)){
            $data = [];
            $obj = json_decode(@file_get_contents('https://data.montpellier3m.fr/sites/default/files/ressources/OSM_Metropole_parking_velo.json'));
            if(is_object($obj) && isset($obj->features) && is_array($obj->features) && count($obj->features) > 0){
                foreach($obj->features as $feature){
                    if(isset($feature->geometry) && isset($feature->geometry->type) && strtolower($feature->geometry->type) === 'point'){
                        $item = [
                            'lat'       => $feature->geometry->coordinates[1],
                            'lng'       => $feature->geometry->coordinates[0],
                            'capacity'  => 0,
                        ];
                        if(isset($feature->properties) && isset($feature->properties->capacity)){
                            $item['capacity'] = (int)$feature->properties;
                        }
                        $data[] = $item;
                    }
                }

            }
            $handler = fopen($file, 'w+');
            fwrite($handler, json_encode($data));
            fclose($handler);
        }
        $data = @json_decode(file_get_contents($file), true);
        $dataJson = [];
        if(is_array($data) && count($data) > 0){
            $dataJson = $data;
        }
        return '<div id="map-velo3m-'.uniqid().'" class="map-velo3m-arceaux" style="width:'.$width.';height:'.$height.';" data-maptype="'.$map.'" data-markers=\''.json_encode($data).'\'></div>';
    }
 }
