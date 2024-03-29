<?php

namespace Common;

use \App\Models\Setting;

// TODO: Create laravel-mix like function to handle timestamped files
// TODO: Create translation function to handle language translations
// TODO: Create csrf_token function and check for it on POST routes
class Twig
{
    protected $twig_environment;

    public function __construct()
    {
        $this->twig_environment = get_twig_environment();

        $this->activeRoute();
        $this->url();
        $this->request();
        $this->setting();
        $this->storageUrl();
        $this->isAuthenticated();
        $this->pagination();
    }

    protected function activeRoute()
    {
        $function = new \Twig\TwigFunction('active_route', function ($value) {
            $route = route();

            // remove leading forward slash
            if (strpos($value, '/') === 0) {
                $value = substr($value, 1);
            }

            // prevent strpos error
            if (strlen($value) === 0) {
                return $route === $value ? 'active-route' : '';
            }

            return strpos($route, $value) === 0 ? 'active-route' : '';
        });
        $this->twig_environment->addFunction($function);
    }

    protected function url()
    {
        $function = new \Twig\TwigFunction('url', function ($value = '/') {
            // remove leading forward slash
            if (strpos($value, '/') === 0) {
                $value = substr($value, 1);
            }

            return base_url() . $value;
        });
        $this->twig_environment->addFunction($function);
    }

    protected function request()
    {
        $function = new \Twig\TwigFunction('request', function ($value = '') {
            return request($value);
        });
        $this->twig_environment->addFunction($function);
    }

    // TODO: Implement method
    protected function setting($value = "")
    {
        $function = new \Twig\TwigFunction('setting', function ($value = '') {
            $setting = Setting
                ::where('title', '=', $value)
                ::first();

            return isset($setting['value']) ? $setting['value'] : "";
        });
        $this->twig_environment->addFunction($function);
    }

    protected function storageUrl()
    {
        $function = new \Twig\TwigFunction('storage_url', function ($value = '') {
            // remove leading forward slash
            if (strpos($value, '/') === 0) {
                $value = substr($value, 1);
            }

            return base_url() . 'storage/' . $value;
        });
        $this->twig_environment->addFunction($function);
    }

    // TODO: Create is_authenticated function to check if there is anybody logged in
    // TODO: actually implement the darn thing
    protected function isAuthenticated()
    {
        $function = new \Twig\TwigFunction('is_authenticated', function () {
            return (bool) rand(0, 1);
        });
        $this->twig_environment->addFunction($function);
    }

    // TODO: Figure out a way to have a consistent number of links to show by
    // messing around with the $default_links_to_show and $links_to_show variables
    // TODO: Don't show the pagination if there is only one link to show
    // TODO: Don't show the link arrows if there are fewer links than the default of links to show
    // TODO: Handle pagination when there is a filter or a search
    // TODO: Handle $filters
    // TODO: Handle both GET and SESSION filters
    protected function pagination()
    {
        $function = new \Twig\TwigFunction('pagination', function (array $items, array $filters = []) {
            $first_item = isset($items[0]) ? $items[0] : null;

            if (is_null($first_item)) {
                return '';
            }

            $current_page = (int) request('page') ?: 0;
            $route = route();
            $total_rows = $first_item['total_rows'];
            $pagination_rows = $first_item['pagination_rows'];
            $total_links = (int) ceil($total_rows / $pagination_rows);
            $default_links_to_show = $links_to_show = 4;

            // Don't show the pagination if there is only one link
            if ($total_links === 1) {
                return '';
            }

            // Retrieve filters from $_GET
            $full_filters = [];
            foreach ($filters as $filter) {
                $request = request($filter);

                if ($request) {
                    $full_filters[$filter] = $request;
                }
            }

            $html = '<div class="row align-center"><ul class="twig-pagination pagination">';

            // Generate previous link
            // TODO: Create a custom function to generate the next and previous html strings
            if ($current_page > 0) {
                $link_nr = $current_page - 1;
                $prev_link = pagination_url($link_nr, $full_filters);

                $html .= '<li class="prev-link">';
                    $html .= "<a href='$prev_link'><</a>";
                $html .= '</li>';
            }

            for ($i = 1; $i <= $total_links; $i++) {
                // TODO: change the number of links to show for init
                // $links_to_show = $default_links_to_show * 2 : $links_to_show;

                if ($i < $current_page - $links_to_show) {
                    continue;
                }

                if ($i > $current_page + $links_to_show) {
                    continue;
                }

                $url = pagination_url($i - 1, $full_filters);

                $active_link = $current_page === $i - 1 ? "active-link" : "";
                $html .= "<li class='$active_link'>";
                    $html .= "<a href='$url'>$i</a>";
                $html .= "</li>";
            }

            // Generate next link
            // TODO: Create a custom function to generate the next and previous html strings
            if ($current_page < $total_links - 1) {
                $link_nr = $current_page + 1;
                $next_link = pagination_url($link_nr, $full_filters);

                $html .= '<li class="next-link">';
                    $html .= "<a href='$next_link'>></a>";
                $html .= '</li>';
            }

            $html .= '</ul></div>';

            return new \Twig\Markup($html, 'UTF-8');
        });
        $this->twig_environment->addFunction($function);
    }
}
