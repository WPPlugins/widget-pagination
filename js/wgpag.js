/*
Plugin Name: Widget Paginator
Plugin URI: http://wgpag.jana-sieber.de/
Description: Pagination for Wordpress Widgets
Author: Jana Sieber and Lars Uebernickel
Author URI: http://wordpress.org/support/profile/janasieber
License: GPL2
*/

jQuery(document).ready(function($) {
    var pages_to_show = parseInt(wgpag_options.pages_to_show) || 7;
    var widgets = wgpag_options.widgets || [];
    var prev_label = wgpag_options.prev_label || '<';
    var next_label = wgpag_options.next_label || '>';

    function navigation(len, cur, showpage) {
        var div = $('<div class="br-pagination"></div>');

        function gotoPage(nr) {
            div.replaceWith(navigation(len, nr, showpage));
            showpage(nr);
        }

        function navelement(n, title) {
            if (n < 1)
                n = 1;
            else if (n > len)
                n = len;
            if (n == cur) {
                return $('<span class="br-current">' + title + '</span>');
            }
            var el = $('<a href="#">' + title + '</a>;');
            el.click(function() { gotoPage(n); return false; });
            return el;
        }

        var first, last;
        if (len <= pages_to_show) {
            first = 2;
            last = len -1;
        }
        else {
            first = cur > 2 ? cur - 1 : 2;
            last = cur < len -1 ? cur + 1 : len -1;
        }

        div.append(navelement(cur -1, prev_label).addClass('br-prev'));
        div.append(navelement(1, 1));
        if (first > 2)
            div.append('<span class="br-separator">&hellip;</span>');
        for (var i = first; i <= last; i++)
            div.append(navelement(i, i));
        if (last < len -1)
            div.append('<span class="br-separator">&hellip;</span>');
        div.append(navelement(len, len));
        div.append(navelement(cur +1, next_label).addClass('br-next'));
        return div;
    }

    for (var i = 0; i < widgets.length; i++) {
        $(widgets[i].selector).children('ul').each(function() {
            var ls = $(this).children('li');
            var items_per_page = widgets[i].count || 10000;
            var npages = Math.ceil(ls.length / items_per_page);
            if (ls.length > items_per_page) {
                function showpage(nr) {
                    var first = (nr - 1) * items_per_page;
                    ls.hide().slice(first, first + items_per_page).show();
                }
                $(this).parent().append(navigation(npages, 1, showpage));
                showpage(1);
            }
        });
    }
});
