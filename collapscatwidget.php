<?php

class collapsCatWidget extends WP_Widget {
    function __construct() {
        $widget_ops = array('classname' => 'widget_collapscat', 'description' =>
            'Collapsible category listing');
        $control_ops = array(
            'width' => '550',
            'height' => '400'
        );
        parent::__construct('collapscat', 'Collapsing Categories', $widget_ops,
            $control_ops);
    }

    function widget($args, $instance) {
        extract($args, EXTR_SKIP);

        $title = apply_filters('widget_title', $instance['title']);
        echo $before_widget;
        if (!empty($title))
            echo $before_title . $title . $after_title;
        $instance['number'] = $this->get_field_id('top');
        $instance['number'] = preg_replace('/[a-zA-Z-]/', '', $instance['number']);
        echo "<ul id='" . $this->get_field_id('top') .
            "' class='collapsing categories list'>\n";
        if (function_exists('collapsCat')) {
            collapsCat($instance);
        } else {
            wp_list_categories();
        }
        echo "</ul>\n";
        echo $after_widget;
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        include('updateOptions.php');
        return $instance;
    }

    function form($instance) {
        include('defaults.php');
        include('collapsCatStyles.php');
        $options = wp_parse_args($instance, $defaults);
        extract($options);

        ?>
      <p>
        <label for="<?php echo $this->get_field_id('title'); ?>">Title: <input
              id="<?php echo $this->get_field_id('title'); ?>"
              name="<?php echo $this->get_field_name('title'); ?>" type="text"
              value="<?php echo esc_attr($title); ?>"/></label>
        <label
            for="<?php echo $this->get_field_id('title_link'); ?>"><?php _e('Link to', 'collapsing-categories') ?>
          : <input id="<?php echo $this->get_field_id('title_link'); ?>"
                   name="<?php echo $this->get_field_name('title_link'); ?>"
                   type="text"
                   value="<?php echo esc_attr($title_link); ?>"/></label>
      </p>
      <p>
        <input type="checkbox"
               name="<?php echo $this->get_field_name('showPostCount'); ?>" <?php if ($showPostCount) echo 'checked'; ?>
               id="<?php echo $this->get_field_id('showPostCount') ?>"/>
        <label
            for="<?php echo $this->get_field_id('showPostCount'); ?>"><?php _e('Show post Count', 'collapsing-categories') ?></label>
      </p>
      <p>
        <input type="checkbox"
               name="<?php echo $this->get_field_name('showPostDate'); ?>" <?php if ($showPostDate) echo
        'checked'; ?>
               id="<?php echo $this->get_field_id('showPostDate'); ?>"/>
        <label
            for="showPostDate"><?php _e('Show Post Date', 'collapsing-categories'); ?></label>
        <select name="<?php echo $this->get_field_name('postDateAppend'); ?>">
          <option <?php if ($postDateAppend == 'before') echo 'selected'; ?>
              id="<?php echo $this->get_field_id('postDateAppendBefore') ?>"
              value='before'><?php _e('Before post title', 'collapsing-categories') ?></option>
          <option <?php if ($postDateAppend == 'after') echo 'selected'; ?>
              id="<?php echo $this->get_field_id('postDateAppendAfter') ?>"
              value='after'><?php _e('After post title', 'collapsing-categories') ?></option>
        </select>
        <label for="postDateFormat"><a href='http://php.net/date'
                                       title='information about date formatting syntax'
                                       target='_blank'>
                <?php _e('as', 'collapsing-categories'); ?></a>:</label>
        <input type="text" size='8'
               name="<?php echo $this->get_field_name('postDateFormat'); ?>"
               value="<?php echo $postDateFormat; ?>"
               id="<?php echo $this->get_field_id('postDateFormat'); ?>"/>
      </p>
      <p>Sort Categories by:&nbsp;
        <select name="<?php echo $this->get_field_name('catSort'); ?>">
          <option <?php if ($catSort == 'catName') echo 'selected'; ?>
              id="sortcatName" value='catName'>category name
          </option>
          <option <?php if ($catSort == 'catId') echo 'selected'; ?>
              id="sortcatId"
              value='catId'>
            category id
          </option>
          <option <?php if ($catSort == 'catSlug') echo 'selected'; ?>
              id="sortcatSlug" value='catSlug'>category Slug
          </option>
          <option <?php if ($catSort == 'catOrder') echo 'selected'; ?>
              id="sortcatOrder" value='catOrder'>category (term) Order
          </option>
          <option <?php if ($catSort == 'catCount') echo 'selected'; ?>
              id="sortcatCount" value='catCount'>category Count
          </option>
        </select>
        <select name="<?php echo $this->get_field_name('catSortOrder'); ?>">
          <option <?php if ($catSortOrder == 'ASC') echo 'selected="selected"'; ?>
              id="<?php echo $this->get_field_id('catSortASC') ?>"
              value='ASC'><?php _e('Ascending', 'collapsing-categories') ?></option>
          <option <?php if ($catSortOrder == 'DESC') echo 'selected="selected"'; ?>
              id="<?php echo $this->get_field_id('catSortDESC') ?>"
              value='DESC'><?php _e('Descending', 'collapsing-categories') ?></option>
        </select>
      </p>
      <p>Sort Posts by:&nbsp;
        <select name="<?php echo $this->get_field_name('postSort'); ?>">
          <option <?php if ($postSort == 'postTitle') echo 'selected'; ?>
              id="<?php echo $this->get_field_id('sortpostTitle') ?>"
              value='postTitle'>post title
          </option>
          <option <?php if ($postSort == 'postId') echo 'selected'; ?>
              id="<?php echo $this->get_field_id('sortpostId') ?>"
              value='postId'>post
            id
          </option>
          <option <?php if ($postSort == 'postComment') echo 'selected'; ?>
              id="<?php echo $this->get_field_id('sortpostComment') ?>"
              value='postComment'>number of Comments
          </option>
          <option <?php if ($postSort == 'postDate') echo 'selected'; ?>
              id="<?php echo $this->get_field_id('sortpostDate') ?>"
              value='postDate'>
            post Date
          </option>
          <option <?php if ($postSort == 'postOrder') echo 'selected'; ?>
              id="<?php echo $this->get_field_id('sortpostOrder') ?>"
              value='postOrder'>Menu order
          </option>
        </select>
        <select name="<?php echo $this->get_field_name('postSortOrder'); ?>">
          <option <?php if ($postSortOrder == 'ASC') echo 'selected="selected"'; ?>
              id="<?php echo $this->get_field_id('postSortASC') ?>"
              value='ASC'><?php _e('Ascending', 'collapsing-categories') ?></option>
          <option <?php if ($postSortOrder == 'DESC') echo 'selected="selected"'; ?>
              id="<?php echo $this->get_field_id('postSortDESC') ?>"
              value='DESC'><?php _e('Descending', 'collapsing-categories') ?></option>
        </select>
      </p>
        <?php
// get taxonomy types
        global $wp_taxonomies;
        ?>
      <p><?php _e('Taxonomy type', 'collapsing-categories') ?>:
        <select name="<?php echo $this->get_field_name('taxonomy'); ?>"
                id="<?php echo $this->get_field_id('taxonomy'); ?>">
          <option <?php if ($taxonomy == 'both') echo 'selected="selected"'; ?>
              value='both'><?php _e('Categories and Tags', 'collapsing-categories') ?></option>
            <?php foreach ($wp_taxonomies as $tax): ?>
              <option <?php if ($taxonomy == $tax->name) echo "selected='selected'" ?>
                  value='<?php echo $tax->name ?>'><?php echo $tax->label ?>
                (<?php echo $tax->name ?>)
              </option>
            <?php endforeach ?>
        </select>
      </p>
        <?php
//get all post types
        global $wp_post_types;
        ?>
      <p><?php _e('Post type', 'collapsing-categories') ?>:
        <select name="<?php echo $this->get_field_name('post_type'); ?>"
                id="<?php echo $this->get_field_id('post_type'); ?>">
            <?php foreach ($wp_post_types as $key => $post): ?>
              <option <?php if ($post_type == $key) echo "selected='selected'" ?>
                  value='<?php echo $key ?>'><?php echo $post->label ?>
                (<?php echo $post->name ?>)
              </option>
            <?php endforeach ?>
        </select>
      </p>
      <p>Expanding shows:
        <input type="radio"
               name="<?php echo $this->get_field_name('showPosts'); ?>" <?php if ($showPosts == true) echo 'checked'; ?>
               id="<?php echo $this->get_field_id('showPostsYes') ?>"
               value='1'/> <label
            for="showPostsYes"><?php _e('Sub-categories and Posts', 'collapsing-categories') ?></label>
        <input type="radio"
               name="<?php echo $this->get_field_name('showPosts'); ?>"
            <?php if ($showPosts == false) echo 'checked'; ?> id="showPostsNo"
               value='0'/> <label
            for="showPostsNO"><?php _e('Just Sub-categories', 'collapsing-categories') ?></label>
      </p>
      <p> Truncate Post Title to
        <input type="text" size='3'
               name="<?php echo $this->get_field_name('postTitleLength') ?>"
               id="<?php echo $this->get_field_id('postTitleLength') ?>"
               value="<?php echo
               $postTitleLength; ?>"/> <label
            for="postTitleLength"> characters</label>
      <p>Clicking on category name:&nbsp;
        <select name="<?php echo $this->get_field_name('linkToCat'); ?>">
          <option <?php if ($linkToCat) echo 'select="selected"'; ?>
              id="<?php echo $this->get_field_id('linkToCatYes'); ?>"
              value='1'><?php _e('Links to category archive', 'collapsing-categories') ?></option>
          <option <?php if (!$linkToCat) echo 'selected="selected"'; ?>
              id="<?php echo $this->get_field_id('linkToCatNo'); ?>"
              value='0'><?php _e('Expands to show sub-categories and/or Posts', 'collapsing-categories') ?></option>
        </select>
      </p>
      <p>Expanding and collapse characters:<br/>
        <strong>html:</strong> <input type="radio"
                                      name="<?php echo $this->get_field_name('expand'); ?>" <?php if ($expand == 0) echo 'checked'; ?>
                                      id="<?php echo $this->get_field_id('expand0') ?>"
                                      value='0'/> <label
            for="<?php echo $this->get_field_id('expand0'); ?>">&#9654;&nbsp;&#9660;</label>
        <input type="radio"
               name="<?php echo $this->get_field_name('expand'); ?>" <?php if ($expand == 1) echo 'checked'; ?>
               id="<?php echo $this->get_field_id('expand1') ?>"
               value='1'/>
        <label
            for="<?php echo $this->get_field_id('expand1'); ?>">+&nbsp;&mdash;</label>
        <input type="radio"
               name="<?php echo $this->get_field_name('expand'); ?>"
            <?php if ($expand == 2) echo 'checked'; ?> id="<?php echo
        $this->get_field_id('expand2') ?>" value='2'/>
        <label
            for="<?php echo $this->get_field_id('expand2'); ?>">[+]&nbsp;[&mdash;]</label>
        <input type="radio"
               name="<?php echo $this->get_field_name('expand'); ?>"
            <?php if ($expand == 4) echo 'checked'; ?> id="<?php echo
        $this->get_field_id('expand4') ?>" value='4'/>
        <label
            for="<?php echo $this->get_field_id('expand4'); ?>"><?php _e('custom', 'collapsing-categories') ?></label>
        expand:
        <input type="text" size='2'
               name="<?php echo $this->get_field_name('customExpand'); ?>"
               value="<?php echo $customExpand ?>"
               id="<?php echo $this->get_field_id('collapsLink') ?>"/>
        collapse:
        <input type="text" size='2'
               name="<?php echo $this->get_field_name('customCollapse'); ?>"
               value="<?php echo $customCollapse ?>"
               id="<?php echo $this->get_field_id('collapsLink') ?>"/>
        <br/>
        <strong>images:</strong>
        <input type="radio"
               name="<?php echo $this->get_field_name('expand'); ?>"
            <?php if ($expand == 3) echo 'checked'; ?> id="<?php echo
        $this->get_field_id('expand0') ?>" value='3'/>
        <label for="<?php echo $this->get_field_id('expand3'); ?>"><img
              src='<?php echo get_option('siteurl') .
                  "/wp-content/plugins/collapsing-categories/" ?>img/collapse.gif'/>&nbsp;<img
              src='<?php echo get_option('siteurl') .
                  "/wp-content/plugins/collapsing-categories/" ?>img/expand.gif'/></label>
      </p>
      <p><?php _e('Auto-expand these categories (separated by commas)',
              'collapsing-categories') ?>:<br/>
        <input type="text"
               name="<?php echo $this->get_field_name('defaultExpand'); ?>"
               value="<?php echo $defaultExpand ?>"
               id="<?php echo $this->get_field_id('defaultExpand') ?>"</input>
      </p>
      <p>
        <select name="<?php echo $this->get_field_name('inExclude'); ?>">
          <option <?php if ($inExclude == 'include') echo 'selected'; ?>
              id="<?php echo $this->get_field_id('inExcludeInclude') ?>"
              value='include'>Include
          </option>
          <option <?php if ($inExclude == 'exclude') echo 'selected'; ?>
              id="<?php echo $this->get_field_id('inExcludeExclude') ?>"
              value='exclude'>Exclude
          </option>
        </select>
        these categories (separated by commas):<br/>
        <input type="text"
               name="<?php echo $this->get_field_name('inExcludeCats'); ?>"
               value="<?php echo $inExcludeCats ?>"
               id="<?php echo $this->get_field_id('inExcludeCats') ?>"</input>
        <br/>
        <input type="checkbox"
               name="<?php echo $this->get_field_name('excludeAll'); ?>" <?php if ($excludeAll == '1') echo
        'checked'; ?>
               id="<?php echo $this->get_field_id('excludeAll'); ?>"/>
        <label
            for="<?php echo $this->get_field_id('excludeAll'); ?>"><?php _e('Exclude post X from categories A and B when A or B is excluded', 'collapsing-categories') ?></label>
      <p>
          <?php _e('Exclude posts older than', 'collapsing-categories') ?>
        <input
            type='text' name="<?php echo $this->get_field_name('olderThan'); ?>"
            id="<?php echo $this->get_field_id('olderThan'); ?>" size='3'
            value='<?php echo $olderThan ?>'/> days
      </p>
      </p>
      <p>Include RSS link
        <input type="radio"
               name="<?php echo $this->get_field_name('catfeed'); ?>"
            <?php if ($catfeed == 'none') echo 'checked'; ?>
               id="<?php echo $this->get_field_id('catfeedNone'); ?>"
               value='none'/> <label
            for="<?php echo $this->get_field_id('catfeedNone'); ?>"><?php _e('None', 'collapsing-categories') ?></label>
        <input type="radio"
               name="<?php echo $this->get_field_name('catfeed'); ?>"
            <?php if ($catfeed == 'text') echo 'checked'; ?>
               id="<?php echo $this->get_field_id('catfeedText'); ?>"
               value='text'/> <label
            for="<?php echo $this->get_field_id('catfeedText'); ?>"><?php _e('text (RSS)', 'collapsing-categories') ?></label>
        <input type="radio"
               name="<?php echo $this->get_field_name('catfeed'); ?>"
            <?php if ($catfeed == 'image') echo 'checked'; ?>
               id="<?php echo $this->get_field_id('catfeedImage'); ?>"
               value='image'/> <label
            for="catfeedImage"><?php _e('image', 'collapsing-categories') ?>
          <img
              src='../wp-includes/images/rss.png'/>'</label>
      </p>
      <p><label
            for='<?php echo $this->get_field_id("style") ?>'><?php _e('Style',
                  'collapsing-categories') ?></label>
        <select id='<?php echo $this->get_field_id("style") ?>'
                name='<?php echo $this->get_field_name("style") ?>'>
            <?php foreach ($styleOptions as $key => $value): ?>
              <option value='<?php echo esc_attr($key) ?>'
                  <?php if ($style == $key) echo "selected='selected'" ?>>
                  <?php echo $value ?></option>
            <?php endforeach ?>
        </select>
      </p>
      <a style='cursor:pointer'
         onclick='showAdvanced("<?php echo $this->get_field_id('advanced') ?>", "<?php echo $this->get_field_id('arrow') ?>");'><span
            id="<?php echo $this->get_field_id('arrow') ?>">&#9654;</span>
        Advanced
        options</a>
      <div id="<?php echo $this->get_field_id('advanced') ?>"
           style='display:none;'>
        <p>
          <input type="checkbox"
                 name="<?php echo $this->get_field_name('addMisc'); ?>"
              <?php if ($addMisc) echo 'checked'; ?>
                 id="<?php echo $this->get_field_id('addMisc'); ?>"/>
          When
          category X has sub-categories, group posts in a sub-category into a
          <input
              type='text'
              name="<?php echo $this->get_field_name('addMiscTitle'); ?>"
              id="<?php echo $this->get_field_id('addMiscTitle'); ?>" size='15'
              value='<?php echo $addMiscTitle ?>'/> category
        </p>
        <p>
          <input type="checkbox"
                 id="<?php echo $this->get_field_id('accordion'); ?>"
                 name="<?php echo $this->get_field_name('accordion'); ?>"
              <?php if ($accordion) echo 'checked'; ?>
                 id="<?php echo $this->get_field_id('accordion'); ?>"/><label
              for="<?php echo $this->get_field_id('accordion'); ?>"><?php _e('Accordion style', 'collapsing-categories') ?>
            <a class='help'
               title='<?php _e('When expanding one category, close all others', 'collapsing-categories') ?>'>?</a></label>
        </p>
        <p>
          <input type="checkbox"
                 name="<?php echo $this->get_field_name('useCookies'); ?>"
              <?php if ($useCookies) echo 'checked'; ?>
                 id="<?php echo $this->get_field_id('useCookies'); ?>"/>
          Remember expanding and collapsing for each visitor (using cookies)
        </p>
        <p>
          <input type="checkbox"
                 name="<?php echo $this->get_field_name('showTopLevel'); ?>"
              <?php if ($showTopLevel) echo 'checked'; ?>
                 id="<?php echo $this->get_field_id('showTopLevel'); ?>"/>
          Show
          top level categories
        </p>
        <p>
          <input type="checkbox" name="<?php echo
          $this->get_field_name('expandCatPost'); ?>"
              <?php if ($expandCatPost) echo 'checked'; ?>
                 id="<?php echo $this->get_field_id('expandCatPost'); ?>"/>
          Expand categories assigned to a particular post on a single post page
        </p>
        <p>
          <input type="checkbox"
                 name="<?php echo $this->get_field_name('postsBeforeCats'); ?>"
              <?php if ($postsBeforeCats) echo 'checked'; ?>
                 id="<?php echo $this->get_field_id('postsBeforeCats'); ?>"/>
          Posts should come before sub-categories
        </p>
        <p>
          <input type="checkbox" name="<?php echo
          $this->get_field_name('showEmptyCat'); ?>"
              <?php if ($showEmptyCat) echo 'checked'; ?>
                 id="<?php echo $this->get_field_id('showEmptyCat'); ?>"/>
          <label
              for='<?php echo $this->get_field_id('showEmptyCat'); ?>'><?php _e('Show Empty Categories', 'collapsing-categories') ?>
        </p>
        <p>
          <input type="checkbox"
                 name="<?php echo $this->get_field_name('debug'); ?>"
              <?php if ($debug == '1') echo 'checked'; ?> id="<?php echo
          $this->get_field_id('debug') ?>"/> <label
              for="<?php echo $this->get_field_id('debug'); ?>">Show debugging
            information
            (shows up as a hidden pre right after the title)</label>
        </p>
      </div>
      <script type='text/javascript'>
        function showAdvanced(advancedId, arrowId) {
          var advanced = document.getElementById(advancedId)
          var arrow = document.getElementById(arrowId)
          if (advanced.style.display == 'none') {
            advanced.style.display = 'block'
            arrow.innerHTML = '&#9660;'
          } else {
            advanced.style.display = 'none'
            arrow.innerHTML = '&#9654;'
          }
        }
      </script>
        <?php
    }
}

function registerCollapsCatWidget() {
    register_widget('collapsCatWidget');
}

add_action('widgets_init', 'registerCollapsCatWidget');
