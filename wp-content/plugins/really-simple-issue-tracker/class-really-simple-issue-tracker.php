<?php

class ReallySimpleIssueTracker {

    const HANDLE = 'really-simple-issue-tracker';

    public function __construct(){
        add_action('plugins_loaded', 'ReallySimpleIssueTracker::registerTextDomain');
        add_action('init', 'ReallySimpleIssueTracker::registerTrackerPostTypeAndTaxonomy');
        add_action('add_meta_boxes', 'ReallySimpleIssueTracker::addMetaBoxes');
    }

    /**
     * Registers the tracker post type and the project taxonomy
     * @static
     */
    public static function registerTrackerPostTypeAndTaxonomy(){
        /* Post type setup */
        $labels = array(
            'name' => __('Issues', self::HANDLE),
            'singular_name' => __('Issue', self::HANDLE),
            'add_new' => __('Add New', self::HANDLE),
            'add_new_item' => __('Add New Issue', self::HANDLE),
            'edit_item' => __('Edit Issue', self::HANDLE),
            'new_item' => __('New Issue', self::HANDLE),
            'all_items' => __('All Issues', self::HANDLE),
            'view_item' => __('View Issue', self::HANDLE),
            'search_items' => __('Search Issues', self::HANDLE),
            'not_found' =>  __('No issue found', self::HANDLE),
            'not_found_in_trash' => __('No issues found in Trash', self::HANDLE),
            'parent_item_colon' => '',
            'menu_name' => __('Issues', self::HANDLE)
        );
        $args = array(
            'labels' => $labels,
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'query_var' => true,
            'rewrite' => array( 'slug' => _x( 'issue', 'URL slug', self::HANDLE ) ),
            'capability_type' => 'post',
            'has_archive' => true,
            'hierarchical' => false,
            'menu_position' => null,
            'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'comments', 'category' )
        );
        register_post_type('issue', $args);

        /* Project taxonomy setup */
        $labels = array(
            'name' => __( 'Projects', self::HANDLE ),
            'singular_name' => __( 'Project', self::HANDLE ),
            'search_items' =>  __( 'Search Projects', self::HANDLE),
            'all_items' => __( 'All Projects', self::HANDLE),
            'parent_item' => __( 'Parent Project', self::HANDLE ),
            'parent_item_colon' => __( 'Parent Project:', self::HANDLE ),
            'edit_item' => __( 'Edit Project', self::HANDLE ),
            'update_item' => __( 'Update Project', self::HANDLE ),
            'add_new_item' => __( 'Add New Project', self::HANDLE ),
            'new_item_name' => __( 'New Project Name', self::HANDLE ),
            'menu_name' => __( 'Projects', self::HANDLE ),
        );
        register_taxonomy( 'project', 'issue', array( 'hierarchical' => true, 'labels' => $labels, 'query_var' => 'project' ) );
    }

    public static function registerTextDomain(){
        load_plugin_textdomain( ReallySimpleIssueTracker::HANDLE, false, dirname( plugin_basename( __FILE__ )) .'/languages/' );
    }

    /**
     * @static
     *
     */
    public static function addMetaBoxes(){
        add_meta_box('assigned-to', __( 'Assigned to', self::HANDLE ), 'ReallySimpleIssueTracker::metaboxAssignedTo', 'issue','side','high');
        add_meta_box('issue-type', __( 'Issue type', self::HANDLE ), 'ReallySimpleIssueTracker::issueType', 'issue','side','high');
        add_meta_box('priority', __( 'Priority', self::HANDLE ), 'ReallySimpleIssueTracker::priority', 'issue','side','high');
        add_meta_box('status', __( 'Status', self::HANDLE ), 'ReallySimpleIssueTracker::metaboxStatus', 'issue','side','high');
        add_meta_box('time', __( 'Time', self::HANDLE ), 'ReallySimpleIssueTracker::metaboxTime', 'issue','side','high');
    }

    /**
     * @static
     *
     */
    public static function metaboxAssignedTo(){
        require_once 'templates/meta-box-assigned-to.php';
    }

    /**
     * @static
     *
     */
    public static function metaboxStatus(){
        require_once 'templates/meta-box-status.php';
    }

    /**
     * @static
     *
     */
    public static function metaboxTime(){
        require_once 'templates/meta-box-time.php';
    }

    /**
     * @static
     *
     */
    public static function issueType(){
        require_once 'templates/meta-box-issue-type.php';
    }

    /**
     * @static
     *
     */
    public static function priority(){
        require_once 'templates/meta-box-priority.php';
    }

    /**
     * @static
     * @param $timeString
     * @return int
     */
    public static function convertEstimatedTimeStringToMinutes($timeString){
        $timeString = trim(str_replace(' ', '',$timeString));
        if($timeString == '')
            return 0;

        $total_minutes = 0;

        // Collect time variables from $timeString
        if(strpos($timeString,'h') > 0) {
            $hours = substr($timeString, 0, strpos($timeString,'h'));
        }
        if(strpos($timeString,'m') > 0) {
            $minutes = isset($hours) ? substr($timeString, strpos($timeString,'h')+1, strpos($timeString,'m')) : substr($timeString, 0, strpos($timeString,'m'));
        }
        if(isset($hours)) {
            $total_minutes = $total_minutes + ($hours * 60);
        }
        if(isset($minutes)) {
            $total_minutes = $total_minutes + $minutes;
        }

        return $total_minutes;
    }

    /**
     * @static
     * @param $minutes
     * @return int|string
     */
    public static function convertMinutesToEstimatedTimeString($minutes){
        $days = floor ($minutes / 1440);
        $hours = floor (($minutes - $days * 1440) / 60);
        $minutes = $minutes - ($days * 1440) - ($hours * 60);
        $returnstr = $days > 0 ? $days .'d ' : '';
        $returnstr .= $hours > 0 ? $hours .'h ' : '';
        $returnstr .= $minutes > 0 ? $minutes .'m' : '';
        $returnstr = strlen($returnstr) == 0 ? 0 : $returnstr;
        return $returnstr;
    }
}