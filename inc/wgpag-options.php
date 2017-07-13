<div class="wrap" id="wgpag-options">
    <div class="icon32" id="icon-themes"></div>

    <h2>Widget Paginator <?php _e("Settings") ?></h2>

    <p>
        Before you can see a paginated list of
        <a href="link-manager.php"><?php _e("Links") ?></a>,
        <a href="edit-tags.php?taxonomy=category"><?php _e("Categories") ?></a>,
        <a href="edit.php"><?php _e("Recent Posts") ?></a>,
        <a href="edit-comments.php"><?php _e("Recent Comments") ?></a>,
        <?php _e("Archives") ?> or <?php _e("Meta") ?>, you need to add them to
        your sidebar(s) by using <a href="widgets.php"><?php _e("Widgets") ?></a>.
    </p>

    <?php
    $default = __("Default");

    if ( isset($_POST['wgpag']) && $_POST['wgpag']=='true' ) {

        //TODO: check, if this saving successfull

        echo '<div id="message" class="updated" style="margin:30px auto 20px; width:600px; cursor:pointer;" onclick="jQuery(\'div#message\').css(\'display\',\'none\');">
                <p style="float:right; font-size:10px; font-variant:small-caps; color:#600000; padding-top:4px;">(close)</p>
                <p><strong>Your settings have been saved.</strong></p>
            </div>';
    }

    // The setting fields will know which settings your options page will handle.
    settings_fields('widget_pagination');
    // replace the form-field markup in the form itself
    //do_settings( 'baw-settings-group' );
    ?>

    <form method="post" action="#">

        <div class="metabox-holder" style="width:30%; float:left; margin-right:3%;">

            <div class="postbox">
                <h3><?php _e("Items per Page") ?></h3>

                <p>If you want a pagination, enter the designated items per
                    page for each widget. Otherwise, leave it emtpy.</p>

                <table class="form-table">
                    <?php
                    foreach ($this->widgets as $w => $name) {
                        $value = get_option('wgpag-items_per_page_' . $w);
                        $name = __($name);
                        echo <<<END
                          <tr>
                            <th>
                              <label for="wgpag-items_per_page_$w">$name:</label>
                            </th>
                            <td>
                              <input type="text" maxlength="2" size="2"
                                     name="wgpag-items_per_page_$w"
                                     id="wgpag-items_per_page_$w"

                                     value="$value" />
                                     <span class="hint">$default: empty</span>
                            </td>
                          </tr>
END;
                    }
                    ?>
                </table>
            </div><!-- /postbox -->

            <div class="postbox">
                <h3><?php _e("Pagination Options") ?></h3>

                <p>Here you can change the defaults for how the pagination is
                    returned.</p>

                <table class="form-table">
                    <tr>
                        <th>
                          <label for="wgpag-pag_option_ptsh">Pages to show:</label>
                        </th>
                        <td>
                          <input type="text" maxlength="2" size="5"
                                 name="wgpag-pag_option_ptsh"
                                 id="wgpag-pag_option_ptsh"
                                 value="<? echo get_option('wgpag-pag_option_ptsh') ?>" />
                          <span class="hint">Maximum number of pages shown in the pagination.
                              If there are more pages, a separator (&hellip;) is shown. &nbsp;|&nbsp; <? echo $default ?>: 7</span>
                        </td>
                    </tr>
                    <tr>
                        <th>
                          <label for="wgpag-pag_option_prev"><?php _e("Previous label") ?>:</label>
                        </th>
                        <td>
                          <input type="text" size="5"
                                 name="wgpag-pag_option_prev"
                                 id="wgpag-pag_option_prev"
                                 value="<? echo get_option('wgpag-pag_option_prev') ?>" />
                          <span class="hint">e.g. prev, &#9664; or &larr; &nbsp;|&nbsp; <? echo $default ?>: &lt;</span>
                        </td>
                    </tr>
                    <tr>
                        <th>
                          <label for="wgpag-pag_option_next"><?php _e("Next label") ?>:</label>
                        </th>
                        <td>
                          <input type="text" size="5"
                                 name="wgpag-pag_option_next"
                                 id="wgpag-pag_option_next"
                                 value="<? echo get_option('wgpag-pag_option_next') ?>" />
                          <span class="hint">e.g. next, &#9654; or &rarr; &nbsp;|&nbsp; <? echo $default ?>: &gt;</span>
                        </td>
                    </tr>
                </table>
            </div><!-- /postbox -->

             <p class="submit">
                <input type="hidden"
                       value="<?php echo wp_create_nonce('wgpag-nonce'); ?>"
                       name="wgpag-nonce" />
                <input type="hidden" value="true" name="wgpag" />
                <input type="submit" value="<?php _e('Save Changes') ?>"
                       class="button-primary" id="submit" name="submit" />
            </p>

        </div><!-- /metabox-holder -->

        <div class="metabox-holder" style="width:30%; float:left; margin-right:3%;">

            <div class="postbox">
                <h3><?php _e("Styling Options") ?></h3>

                <p>If you want to change the appearance of the pagination,
                    enter the designated value. Otherwise, leave it emtpy.</p>

                <h4><?php _e("Current pagination item") ?></h4>

                <table class="form-table">
                    <tr>
                        <th>
                          <label for="wgpag-cur_item_style_color">Text colour:</label>
                        </th>
                        <td>
                          <input type="text" size="7"
                                 name="wgpag-cur_item_style_color"
                                 id="wgpag-cur_item_style_color"
                                 class="color-picker"
                                 value="<? echo get_option('wgpag-cur_item_style_color') ?>" />
                          <span class="hint">e.g. red or #00000 &nbsp;|&nbsp; <? echo $default ?>: theme</span>
                        </td>
                    </tr>
                    <tr>
                        <th>
                          <label for="wgpag-cur_item_style_border-color">Border colour:</label>
                        </th>
                        <td>
                          <input type="text" size="7"
                                 name="wgpag-cur_item_style_border-color"
                                 id="wgpag-cur_item_style_border-color"
                                 class="color-picker"
                                 value="<? echo get_option('wgpag-cur_item_style_border-color') ?>" />
                          <span class="hint"><? echo $default ?>: transparent</span>
                        </td>
                    </tr>
                    <tr>
                        <th>
                          <label for="wgpag-cur_item_style_background-color">Background colour:</label>
                        </th>
                        <td>
                          <input type="text" size="7"
                                 name="wgpag-cur_item_style_background-color"
                                 id="wgpag-cur_item_style_background-color"
                                 class="color-picker"
                                 value="<? echo get_option('wgpag-cur_item_style_background-color') ?>" />
                          <span class="hint"><? echo $default ?>: #F1F1F1</span>
                        </td>
                    </tr>
                    <tr>
                        <th>
                          <label for="wgpag-cur_item_style_font-size">Font size:</label>
                        </th>
                        <td>
                          <input type="text" size="7" maxlength="4"
                                 name="wgpag-cur_item_style_font-size"
                                 id="wgpag-cur_item_style_font-size"
                                 value="<? echo get_option('wgpag-cur_item_style_font-size') ?>" />
                          <span class="hint">e.g. 12px or 10em &nbsp;|&nbsp; <? echo $default ?>: theme</span>
                        </td>
                    </tr>
                </table>

                <h4><?php _e("Linked pagination items") ?></h4>

                <table class="form-table">
                    <tr>
                        <th>
                          <label for="wgpag-item_style_color">Text colour:</label>
                        </th>
                        <td>
                          <input type="text" size="7"
                                 name="wgpag-item_style_color"
                                 id="wgpag-item_style_color"
                                 class="color-picker"
                                 value="<? echo get_option('wgpag-item_style_color') ?>" />
                          <span class="hint"><? echo $default ?>: theme</span>
                        </td>
                    </tr>
                    <tr>
                        <th>
                          <label for="wgpag-item_style_border-color">Border colour:</label>
                        </th>
                        <td>
                          <input type="text" size="7"
                                 name="wgpag-item_style_border-color"
                                 id="wgpag-item_style_border-color"
                                 class="color-picker"
                                 value="<? echo get_option('wgpag-item_style_border-color') ?>" />
                          <span class="hint"><? echo $default ?>: #F1F1F1</span>
                        </td>
                    </tr>
                    <tr>
                        <th>
                          <label for="wgpag-item_style_background-color">Background colour:</label>
                        </th>
                        <td>
                          <input type="text" size="7"
                                 name="wgpag-item_style_background-color"
                                 id="wgpag-item_style_background-color"
                                 class="color-picker"
                                 value="<? echo get_option('wgpag-item_style_background-color') ?>" />
                          <span class="hint"><? echo $default ?>: transparent</span>
                        </td>
                    </tr>
                    <tr>
                        <th>
                          <label for="wgpag-item_style_font-size">Font size:</label>
                        </th>
                        <td>
                          <input type="text" size="7" maxlength="4"
                                 name="wgpag-item_style_font-size"
                                 id="wgpag-item_style_font-size"
                                 value="<? echo get_option('wgpag-item_style_font-size') ?>" />
                          <span class="hint"><? echo $default ?>: theme</span>
                        </td>
                    </tr>
                </table>

                <h4><?php _e("Mouseover on linked pagination items") ?></h4>

                <table class="form-table">
                    <tr>
                        <th>
                          <label for="wgpag-hover_item_style_color">Text colour:</label>
                        </th>
                        <td>
                          <input type="text" size="7"
                                 name="wgpag-hover_item_style_color"
                                 id="wgpag-hover_item_style_color"
                                 class="color-picker"
                                 value="<? echo get_option('wgpag-hover_item_style_color') ?>" />
                          <span class="hint"><? echo $default ?>: theme</span>
                        </td>
                    </tr>
                    <tr>
                        <th>
                          <label for="wgpag-hover_item_style_border-color">Border colour:</label>
                        </th>
                        <td>
                          <input type="text" size="7"
                                 name="wgpag-hover_item_style_border-color"
                                 id="wgpag-hover_item_style_border-color"
                                 class="color-picker"
                                 value="<? echo get_option('wgpag-hover_item_style_border-color') ?>" />
                          <span class="hint"><? echo $default ?>: theme</span>
                        </td>
                    </tr>
                    <tr>
                        <th>
                          <label for="wgpag-hover_item_style_background-color">Background colour:</label>
                        </th>
                        <td>
                          <input type="text" size="7"
                                 name="wgpag-hover_item_style_background-color"
                                 id="wgpag-hover_item_style_background-color"
                                 class="color-picker"
                                 value="<? echo get_option('wgpag-hover_item_style_background-color') ?>" />
                          <span class="hint"><? echo $default ?>: theme</span>
                        </td>
                    </tr>
                    <tr>
                        <th>
                          <label for="wgpag-hover_item_style_font-size">Font size:</label>
                        </th>
                        <td>
                          <input type="text" size="7" maxlength="4"
                                 name="wgpag-hover_item_style_font-size"
                                 id="wgpag-hover_item_style_font-size"
                                 value="<? echo get_option('wgpag-hover_item_style_font-size') ?>" />
                          <span class="hint"><? echo $default ?>: theme</span>
                        </td>
                    </tr>
                </table>
            </div><!-- /postbox -->
        </div><!-- /metabox-holder -->
    </form>

    <div class="metabox-holder" style="width:30%; float:right;">

        <div class="postbox">
            <h3><?php _e("Contact the Plugin Developers") ?></h3>

            <p>
                You have a <strong>question</strong>, want to report a <strong>bug</strong>,
                help <strong>translating</strong>, or suggest a <strong>feature</strong>?
            </p>
            <p>
                &rarr;
                <a href="http://wordpress.org/tags/widget-pagination?forum_id=10">plugin forum</a><br />
                &rarr;
                <a href="http://wgpag.jana-sieber.de/">plugin homepage</a>
            </p>
        </div>

        <div class="postbox">
            <h3><?php _e("Information for Developers") ?></h3>

            <p>
                If you are using
                <a href="http://codex.wordpress.org/Function_Reference/wp_list_bookmarks"><i>wp_list_bookmarks()</i></a>,
                just set the parameter 'class' to 'widget_links'.<br />
                Meanwhile, we are working on a solution for
                wp_get_archives(), wp_list_categories(), wp_list_authors(),
                wp_list_pages() and wp_list_comments.
            </p>
        </div>
    </div><!-- /metabox-holder -->
</div><!-- /wrap -->

<!-- required to clear for additional content -->
<div style="clear:both;"></div>