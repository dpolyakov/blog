<?
// +----------------------------------------------------------------------+
// | Easy Image Photo Gallery Script 1.3                                  |
// +----------------------------------------------------------------------+
// | Copyright (c) 2005 www.php4script.com                                |
// +----------------------------------------------------------------------+
// | Author: www.php4script.com <support@php4script.com>                  |
// +----------------------------------------------------------------------+


/******************************* CONFIGURATION ********************************/

/* CSS settings

  To configure the look of the links and texts define the following classes in the your CSS file:
    `nav` for the navigation links
    `nav_current` for the current page digit
    `copy` for the `www.php4script.com` link and `Powered by` text
    `description` for the description if used

*/

/* sort mode: available values:
0 - sort by name asc
1 - sort by name desc
2 - sort by file time asc
3 - sort by file time desc
4 - sort by file size asc
5 - sort by file size desc
*/



//////////////////////////////////////////////////////////////////////////////
//
// NEED MORE FEATURES?
//
// Try our AZ Photo Album Script PRO
// http://php4script.com/php-photo-album-script/
//
// FEATURES
//
// * Free installation<br>
// * Watermark Support<br>
// * Mass changes: rotating/moving/sorting/deleting<br>
// * Automatic thumbnails generation<br>
// * Automatically resize photo to make it fit on the front-end display<br>
// * 3 types of navigation<br>
// * Password protected admin area<br>
// * Skins support<br>
// * Easy template system to make your own custom skins<br>
// * Fit easily into your web design<br>
// * Add, edit or delete photo categories<br>
// * Use FTP Uploading to help you speed up photos adding<br>
// * Set Photo Gallery display properties<br>
// * Easy installation (online installer)
// * and more...
//
////////////////////////////////////////////////////////////////////////////////


define(SORT_MODE, 0);


// read JPEG files (1 - yes, 0 - no)
define('READ_JPG', 1);

// read GIF files (1 - yes, 0 - no)
define('READ_GIF', 1);

// read PNG files (1 - yes, 0 - no)
define('READ_PNG', 1);

// hide the `IPGS 1.3` link (1 - hide, 0 - show)
define('HIDE_COPY', 1);

// header file
// if you need to use a header file you can specify a path to that file
define('HEADER_FILE', 'header.htm');

// footer file
// if you need to use a footer file you can specify a path to that file
define('FOOTER_FILE', 'footer.htm');


// culculate image size (1 - culculate 0 - not calculate)
define('CULC_IMAGE_SIZE', 1);



/*
If you want to have a some titles/descriptions for your photos just create 
a description.txt file at the same folder where script lacated

Fromat of description.txt file is: file_name::some_text

example:
photo1.jpg::My first photo
photo2.gif::My second photo


*/
// name of description file
define('DESCRIPTION_FILENAME', 'description.txt');




/************************  DO NOT EDIT ANY CODE BELOW *************************/
error_reporting(0);

// pagenav
define ("PAGENAV_PERPAGE",15);
define ("PAGENAV_TOTALRECS",355);
define ("PAGENAV_MINPAGES",6);
define ("PAGENAV_MAXPAGES",10);
define ("PAGENAV_CURRPAGEOFFSET",-1);
define ("PAGENAV_PERSET",10);
define ("PHOTOS_PER_PAGE", 1);


$p = split('/', $_SERVER['SCRIPT_FILENAME']);
$script_name = $p[count($p)-1];
$path = str_replace($script_name, '', $_SERVER['SCRIPT_FILENAME']);

$allowed_ext = array();
if(READ_JPG == 1) {
  array_push($allowed_ext, 'jpg');
}
if(READ_GIF == 1) {
  array_push($allowed_ext, 'gif');
}
if(READ_PNG == 1) {
  array_push($allowed_ext, 'png');
}


$path = './';
$dir = dir($path);
if(empty($_GET['start'])) $_GET['start'] = 1;


$c0 = array(60,98,114,62,60,100,105,118,32,97,108,105,103,110,61,34,99,101,110,116,101,114,34,32,115,116,121,108,101,61,34,102,111,110,116,45,102,97,109,105,108,121,58,118,101,114,100,97,110,97,59,102,111,110,116,45,115,105,122,101,58,56,112,120,59,99,111,108,111,114,58,115,105,108,118,101,114,59,34,62,60,97,32,116,105,116,108,101,61,34,69,97,115,121,32,73,109,97,103,101,32,80,104,111,116,111,32,71,97,108,108,101,114,121,32,83,99,114,105,112,116,46,32,80,111,119,101,114,101,100,32,98,121,32,104,116,116,112,58,47,47,119,119,119,46,112,104,112,52,115,99,114,105,112,116,46,99,111,109,34,32,115,116,121,108,101,61,34,102,111,110,116,45,102,97,109,105,108,121,58,118,101,114,100,97,110,97,59,102,111,110,116,45,115,105,122,101,58,56,112,120,59,99,111,108,111,114,58,115,105,108,118,101,114,59,34,32,99,108,97,115,115,61,34,99,111,112,121,95,108,105,110,107,34,32,104,114,101,102,61,34,104,116,116,112,58,47,47,119,119,119,46,112,104,112,52,115,99,114,105,112,116,46,99,111,109,47,63,105,100,61,49,34,62,60,115,112,97,110,32,99,108,97,115,115,61,34,99,111,112,121,34,62,80,104,111,116,111,32,71,97,108,108,101,114,121,32,83,99,114,105,112,116,32,118,49,46,51,60,47,115,112,97,110,62,60,47,97,62,60,47,100,105,118,62);
$c1 = array(60,97,32,116,105,116,108,101,61,34,69,97,115,121,32,73,109,97,103,101,32,80,104,111,116,111,32,71,97,108,108,101,114,121,32,83,99,114,105,112,116,46,32,80,111,119,101,114,101,100,32,98,121,32,104,116,116,112,58,47,47,119,119,119,46,112,104,112,52,115,99,114,105,112,116,46,99,111,109,34,32,104,114,101,102,61,34,104,116,116,112,58,47,47,119,119,119,46,112,104,112,52,115,99,114,105,112,116,46,99,111,109,47,63,105,100,61,49,34,62,60,105,109,103,32,97,108,116,61,34,69,97,115,121,32,73,109,97,103,101,32,80,104,111,116,111,32,71,97,108,108,101,114,121,32,83,99,114,105,112,116,46,32,80,111,119,101,114,101,100,32,98,121,32,104,116,116,112,58,47,47,119,119,119,46,112,104,112,52,115,99,114,105,112,116,46,99,111,109,34,32,98,111,114,100,101,114,61,34,48,34,32,119,105,100,116,104,61,34,49,34,32,104,101,105,103,104,116,61,34,49,34,32,115,114,99,61,34,95,95,115,112,97,99,101,114,46,103,105,102,34,62,60,47,97,62);
$total_size = 0;
while ($file = $dir->read()) {
//  if(array_sum($c) != 16284) break;
  if (($file != '.') && ($file != 'CVS') && ($file != '..')) {
    $file_size = filesize($path . $file);
    
    $ext = file_ext($file);
    if(!is_dir($path . $file) && isset($ext) && in_array($ext, $allowed_ext)) {
      
      $images[] = array('name' => $file,
                        'last_modified' => filemtime($path . $file),
                        'size' => $file_size,
                         );
    }
  }
}


// sort order
$sort_mode = array(
0 => 'cmp_name_asc',
1 => 'cmp_name_desc',
2 => 'cmp_time_asc',
3 => 'cmp_time_desc',
4 => 'cmp_size_asc',
5 => 'cmp_size_desc',
);
uasort($images, $sort_mode[SORT_MODE]);

foreach($images as $_i => $_d) {
  $new_images[] = $_d;
}
$images = $new_images;
// end: sort order


if(count($images) <= 0) {
  echo 'No images found';
  exit;
}


$filename = $images[$_GET['start']-1]['name'];

$description = read_description();

if(file_exists($path . $filename)) {
  $imgsize_str = ' ';
  if(CULC_IMAGE_SIZE == 1) {
    $imgsize = getimagesize($path . $filename);
    $imgsize_str .= $imgsize[3];
  }
  
  if(isset($description[$filename])) {
    $descr = $description[$filename];
    $alt = trim($description[$filename]);
  } else {
    $alt = $filename;
  }
  
  $image = '<br/><input type="text" value="http://pic.dimapolyakov.ru/' . $filename . '" onclick="this.select()" size="80%" readonly /><br/><br/><img alt="' . $alt . '" src="' . $filename . '"' . $imgsize_str . '>';
} else {
  $image = 'Image not found';
}


$nav = nav(count($images));
$image_html = '<tr><td align="center">' . $image . '</td></tr>';
$descr_html = '';
if(isset($descr)) {
  $descr_html = '<tr><td align="center" class="description">' . $descr . '</td></tr>';
}
$nav_html = '<tr><td align="center">' . $nav . '</td></tr>';

$output = '<table align="center">' . $nav_html . $image_html . $descr_html . '</table>';

if(file_exists(HEADER_FILE)) {
  echo implode('', file(HEADER_FILE));
}

echo $output;
$count = count(${'c'.HIDE_COPY});
print "\n\n\n";

print "\n\n\n";

if(file_exists(FOOTER_FILE)) {
  echo implode('', file(FOOTER_FILE));
}


function file_ext($file) {
  $extension = split("[.]", $file);
  $ext_file = $extension[count($extension)-1];
  return strtolower($ext_file);
}


function nav($total_rows) {
  $pagenav = new PageNavigator_ManualScroll($_GET['start'], PHOTOS_PER_PAGE, $total_rows, PAGENAV_PERSET, array('from'=>'start'));
  $pagenav->parametersNot = array('start');
  $pagenav->autoLoadFromQuery();
  $pagenav->getRange($pagenav->getCurrentPage(), $firstrec, $lastrec);
  return $pagenav->render();
}


function read_description() {
  global $path;
  $data = array();
  $d = array();
  if(file_exists($path . DESCRIPTION_FILENAME)) {
    $data = file($path . DESCRIPTION_FILENAME);
  }
  $num = count($data);
  if($num > 0) {
    for($i=0; $i < $num; $i++) {
      list($file, $descr) = split('::', $data[$i]);
      $d[$file] = $descr;
    }
  }
  return $d;
}




class PageNavigator
{
    /**
    * Number of the current page.
    *
    * @var      integer
    * @access   private
    */
    var $current_page;

    /**
    * Number of records per one page.
    *
    * @var      integer
    * @access   private
    */
    var $records_per_page;

    /**
    * Total records in the data set.
    *
    * @var      integer
    * @access   private
    */
    var $total_records = 0;

    /**
    * Processed query string.
    *
    * @var      integer
    * @access   private
    */
    var $processed_query;

    /**
    * Number of pages. This is a cached copy.
    *
    * @var      integer
    * @access   private
    */
    var $totalpages;

    /**
    * Number of page to start with.
    *
    * @var      integer
    * @access   private
    */
    var $startpage;

    /**
    * Number of page to end with.
    *
    * @var      integer
    * @access   private
    */
    var $endpage;

    /**
    * Specifies which parameters go into produced query strings.
    *
    * @var      array
    * @access   private
    */
    var $query_vars;

    /**
    * String to print instead of a link / navigation label if there is none.
    *
    * @var      string
    * @access   private
    */
    var $empty_cell = '&nbsp;';
    
    /**
    * String parametrs unnecessary parameters in navigation link.
    *
    * @var      string
    * @access   private
    */
    var $parametersNot ='';
    
    /**
    * String accompaniment necessary parameter in navigation link.
    *
    * @var      string
    * @access   private
    */
    var $parametersGet ='';

    /**
    * Constructor. Initializes the PageNavigator object with the most important
    * properties.
    *
    * @param    integer    current page number
    * @param    integer    number of records per one page
    * @param    integer    total records. May be initialized later.
    * @return   void
    * @access   public
    */
    function PageNavigator($current_page=0, $records_per_page=15, $total_records=0, $query_vars='')
    {
        $this->setCurrentPage($current_page); //
        $this->setRecordsPerPage($records_per_page);
        $this->setRecordCount($total_records);

        $this->setQueryVars($query_vars);

    } // end func PageNavigator

    /**
    * Sets the number of records to span.
    *
    * @param    integer    number of records in data set
    * @return   void
    * @access   public
    */
    function setRecordCount($rec_num)
    {
        $this->total_records = $rec_num;
    }

    /**
    * Returns the number of records to span.
    *
    * @return   integer
    * @access   public
    */  
    function getRecordCount()
    {
        return $this->total_records;
    }

    /**
    * Sets the current page.
    *
    * @param    integer    current page
    * @return   void
    * @access   public
    */
    function setCurrentPage($current_page)
    {
        if (empty($current_page) || $current_page <= 0) $current_page = 1;

        $this->current_page = $current_page;
    }

    /**
    * Returns the current page.
    *
    * @return   integer    current page
    * @access   public
    */
    function getCurrentPage()
    {
        return $this->current_page;
    }

    /**
    * Sets records per page.
    *
    * @param    integer    records per page
    * @return   void
    * @access   public
    */
    function setRecordsPerPage($records_per_page)
    {
        $this->records_per_page = $records_per_page;
    }

    /**
    * Returns records per page.
    *
    * @return   integer    records per page
    * @access   public
    */
    function getRecordsPerPage()
    {
        return $this->records_per_page;
    }

    /**
    * Returns total number of pages using number of records and
    * records per page (already saved to object member variables).
    *
    * @return   integer    total number of pages
    * @access   public
    */
    function getTotalPages()
    {
        return ceil($this->total_records / $this->records_per_page);
    }

    /**
    * Sets query string variables to purge from / save to target query string
    *
    * @return   void
    * @access   public
    */
    function setQueryVars($vars='')
    {
        if (!is_array($vars)) $vars = array('page'=>'page');

        $this->query_vars = $vars;
    } // end func setQueryVars

    /**
    * Returns the start and end record for the given page by reference.
    *
    * @return   boolean    false if the given page exceeds the total
    * number of pages and true if calculations are successful
    * @access   public
    */
    function getRange($pagenum, &$startrecord, &$endrecord)
    {
        if ($pagenum > $this->getTotalPages())
        {
            return false;
        }
        
        // calculate start record
        $startrecord = ($pagenum==1 ? 1 : (($pagenum - 1) * $this->records_per_page) + 1);

        // calculate end record
        $endrecord = $startrecord + $this->records_per_page - 1; // initial
        if ($endrecord > $this->total_records)
            $endrecord = $this->total_records; // fix if out of bounds

        return true;
    } // end func getRange

    /**
    * Returns the page number given the start record and number of records
    * per one page
    *
    * @return   integer    page number that corresponds to the passed parameters
    * @access   public
    */
    function toPage($startrec, $records_per_page)
    {
        $page = ($startrec > 0 ? ceil($startrec / $records_per_page) : 1);

        return $page;
    } // end func toPage

/*
* METHODS TO OVERRIDE IN CUSTOM CLASSES
*/

    function preCalculateParameters()
    {
        $this->totalpages = $this->startpage = $this->endpage = 0;
    }
    
    function render()
    {
        die('PageNavigator::Render needs to be overridden.');
    }
    function formatActivePage($pagenum)
    {
        return "<b class=nav_current>$pagenum</b>&nbsp;&nbsp;";
    }
    function formatPage($pagenum)
    {
        return "<a class=nav  href=\"".$this->getTargetUrl($pagenum)."\"><u>$pagenum</u></a>&nbsp;&nbsp;";

    }
    function formatMovePrevious($pagenum)
    {
        return "<a class=nav  href=\"".$this->getTargetUrl($pagenum)."\"><u>&lt;</u></a>&nbsp;&nbsp;";
    }
    function formatMoveNext($pagenum)
    {
        return "<a class=nav  href=\"".$this->getTargetUrl($pagenum)."\"><u>&gt;</u></a>&nbsp;&nbsp;";
    }
    function formatMovePrevSet($pagenum)
    {
        return "<a class=nav  href=\"".$this->getTargetUrl($pagenum)."\"><u>&lt;&lt;</u></a>&nbsp;&nbsp;";
    }
    function formatMoveNextSet($pagenum)
    {
        return "<a class=nav  href=\"".$this->getTargetUrl($pagenum)."\"><u>&gt;&gt;</u></a>&nbsp;&nbsp;";
    }
    function formatHeader()
    {
        return "";
    }
    function formatFooter()
    {
        return "\n";
    }
    
/*
* PRIVATE UTILITY METHODS
*/

    /**
    * Counts results contained in an sql query by constructing
    * a special sql query from given params and executing it 
    * against the database identifier (uses PHPLIB)
    *
    * @param    resource   database resource identifier
    * @param    string     if $tablejoin_valid is false, this is the entire
    *                      SQL statement. If $tablejoin_valid is true, 
    *                      this is only the entire valid table join.
    * @param    string     SQL WHERE clause
    * @param    boolean    true if the second parameter is to be used as 
    *                      the list of tables (join) to use. False if
    *                      the second parameter is to be used as the entire
    *                      SQL statement.
    *
    * @return   integer    number of records in the data set
    * @access   public
    */
    function countDbRecords(&$DB, $sql_table_join, $where_clause="", $tablejoin_valid=true)
    {
        $ret = 0; // default return value
        
        if ($tablejoin_valid == true)
        {
            $sql = "SELECT COUNT(*) AS num from $sql_table_join ";
            if (empty($where_clause) || 
                strpos(' '.strtolower($where_clause), 'where') == 0)
            {
                $sql .= "WHERE ";
            }
            $sql .= $where_clause;
        }
        else
        {
            $sql = $sql_table_join;
        }
        
        $query = new query($DB, $sql);
        $row = $query->getrow();
        if (is_array($row))
        {
            $ret = (int)$row['num'];
        }
        $query->free();

        return $ret;
    } // end func countDbRecords

    /**
    * Automatically loads and sets current page variables within PageNavigator.
    *
    * @return   void
    * @access   public
    */
    function autoLoadFromQuery()
    {
        if (is_array($this->query_vars))
        {
            if (isset($this->query_vars['page']))
            {
                $var = $this->query_vars['page'];
                
                $this->setCurrentPage($_GET[$var]);
            }
            elseif (isset($this->query_vars['from']))
            {
                // adjust records per page if necessary
                if (isset($this->query_vars['count']))
                {
                    $var = $this->query_vars['count'];
                    
                    $this->setRecordsPerPage($_GET[$var]);
                }
                // load current page
                $var = $this->query_vars['from'];
                
                $this->setCurrentPage( 
                    $this->toPage($_GET[$var], $this->getRecordsPerPage())
                    );
            }
        }
    } // end func autoLoadFromQuery

    /**
    * Clears the query string of all variables that are needed
    * by this class (i.e. $page or $from/$to, $from/$num) and returns it.
    *
    * @param    array     array of strings identifying variables that need to be stripped from the current URI query string
    * @return   string    stripped query string
    * @access   public
    */
    function getStrippedQueryString($vars_array)
    {
        $query_vars = $_GET;
        
        // strip control variables
        foreach ($vars_array as $v)
        {
            unset($query_vars[$v]);
        }
        $qr = '';
        foreach ($query_vars as $k=>$v)
        {
            $qr .= $k.'='.urlencode($v).'&';
        }
        if (!empty($qr)) $qr = substr($qr, 0, -1);
        
        return $qr;
    } // end func getStrippedQueryString

    /**
    * Returns the link to jump to.
    *
    * @return   string    target link
    * @access   private
    */
    function getTargetUrl($pagenum)
    {
        
        $query_str = $this->processed_query;
        
        $query_str = $this->get_all_get_params($this->parametersNot);

        if (!empty($query_str))
        {
            $query_str .= "&";
        }


        return str_replace('//', '/', $_SERVER['PHP_SELF'])."?".$query_str.$this->prepareQueryVars($pagenum).$this->parametersGet;

    } // end func getTargetUrl


    /**
    * Returns the link without params in $exclude_array to jump to.
    *
    * @return   string    target link
    * @access   private
    */
    function get_all_get_params($exclude_array = '') {
      
      if ($exclude_array == '') $exclude_array = array();
      $get_url = '';
      reset($_GET);
      while (list($key, $value) = each($_GET)) {
        if (($key != 'error') && (!in_array($key, $exclude_array))) $get_url .= $key . '=' . $value . '&';
      }
      return substr($get_url, 0, -1);
    }


    /**
    * Returns a string to be inserted into the URL to switch pages
    * (i.e. page=2 or start=11&limit=10, etc). Override this to parse in
    * the manner you see fit)
    *
    * @param    integer    number of page
    * @return   string     string tobe inserted into the URL
    * @access   private
    */
    function prepareQueryVars($pagenum)
    {
        if (is_array($this->query_vars))
        {
            if (isset($this->query_vars['page']))
            {
                $ret = $this->query_vars['page'].'='.$pagenum;
            }
            elseif (isset($this->query_vars['from']))
            {
                $from = ($pagenum * $this->records_per_page) - $this->records_per_page + 1;
                
                if (isset($this->query_vars['count']))
                {
                    $ret = $this->query_vars['from'].'='.$from.'&'.
                        $this->query_vars['count'].'='.
                        $this->records_per_page;
                }
                else
                {
                    $ret = $this->query_vars['from'].'='.$from;
                }
            }
        }
        return $ret;

    } // end func prepareQueryVars

    /**
    * Caches the copy of the query string, first purging it of all variables
    * like page, from, to, etc, depending on what the developer intends to do
    *
    * @return   void
    * @access   private
    */
    function setProcessedQueryString()
    {
        $this->processed_query =
                    $this->getStrippedQueryString($this->query_vars);
    } // end func setProcessedQueryString

} // end class PageNavigator


class PageNavigator_ManualScroll extends PageNavigator
{
    /**
    * Number of pages to show within one set of pages.
    *
    * @var      integer
    * @access   private
    */
    var $pages_per_set;

    /**
    * Constructor. Initializes the PageNavigator_ManualScroll object with the 
    * most important properties.
    *
    * @param    integer    current page number
    * @param    integer    number of records per one page
    * @param    integer    total records. May be initialized later.
    * @param    integer    number of pages to be displayed per one set of
    *                      pages. If there are more pages than this figure, 
    *                      the button rendered by formatMoveNextSet() will be
    *                      available to the right. Same for the left button
    *                      navigating the user to the previous set of pages.
    * @return   void
    * @access   public
    */
    function PageNavigator_ManualScroll($current_page=0, $records_per_page=15, $total_records=0, $pages_per_set=10, $query_vars='')
    {
        PageNavigator::PageNavigator($current_page, $records_per_page, $total_records, $query_vars);

        $this->pages_per_set = $pages_per_set;

    } // end func

    /*
    PagesPerSet
    */
    function setPagesPerSet($pages_per_set)
    {
        $this->pages_per_set = $pages_per_set;
    }
    function getPagesPerSet()
    {
        return $this->pages_per_set;
    }

    /**
    * Returns the set we are on.
    *
    * @return   integer    current set of pages
    * @access   public
    */
    function getCurrentSet()
    {
        return floor(($this->current_page - 1) / $this->pages_per_set);
    }

    function preCalculateParameters()
    {
        $this->totalpages = $this->getTotalPages();
        
        $this->startpage = ($this->getCurrentSet() * $this->pages_per_set) + 1;

        if (($this->startpage + $this->pages_per_set - 1) > $this->totalpages)
        {
            $this->endpage = $this->totalpages;
        }
        else
        {
            $this->endpage = $this->startpage + $this->pages_per_set - 1;
        }
    } // end func preCalculateParameters

    function render()
    {
        // do not allow to proceed if not initialized correctly
        if ($this->total_records == 0)
        {
            return false;
        }
        
        // HEADER
        $output = $this->formatHeader();
        
        // GET INITIAL VARS
        $this->preCalculateParameters(); // calculate totalpages, startpage, endpage
        $set = $this->getCurrentSet();

        // CACHE QUERY STRING STRIPPED OF VARIABLES NEEDED BY THIS CLASS
        $this->setProcessedQueryString();
        
        // first generate all cells containing links to various pages
        $pages = '';
        for ($int = $this->startpage; $int <= $this->endpage; $int++)
        {
            $pages .= ( ($int == $this->current_page) ?
                    $this->formatActivePage($int) :
                    $this->formatPage($int) );

        }
        
        //  LINK TO PREVIOUS SET
        if ($set > 0)
        {
            $prevset = $this->formatMovePrevSet($this->current_page - $this->pages_per_set);
        } 
        else
        {
            $prevset = $this->empty_cell;
        }
        
        //  LINK TO PREVIOUS PAGE
        if ($this->current_page > 1)
        {
            $prevpage = $this->formatMovePrevious($this->current_page - 1);
        }
        else
        {
            $prevpage = $this->empty_cell;
        }

        //  LINK TO NEXT PAGE
        if ($this->current_page < $this->totalpages)
        {
            $nextpage = $this->formatMoveNext($this->current_page + 1);
        }
        else
        {
            $nextpage = $this->empty_cell;
        }

        //  LINK TO NEXT SET
        if ( ($this->endpage + 1) <= $this->totalpages )
        {
            $nextset = $this->formatMoveNextSet($this->endpage + 1);
        }
        else
        {
            $nextset = $this->empty_cell;
        }
        
        // RENDER PAGE NAVIGATION VIEW
        $output .= $prevset.$prevpage.$pages.$nextpage.$nextset;
        
        // ADD TABLE FOOTER
        $output .= $this->formatFooter();
        
        return $output;
    } // end func render

} // end class PageNavigator_ManualScroll


function cmp_name_asc(&$a, &$b) 
{ 
    if ($a['name']==$b['name']) return 0; 
        return ($a['name']<$b['name']) ? -1 : 1; 
}
function cmp_name_desc(&$a, &$b) 
{ 
    if ($a['name']==$b['name']) return 0; 
        return ($a['name']>$b['name']) ? -1 : 1; 
}
function cmp_time_asc(&$a, &$b) 
{ 
    if ($a['last_modified']==$b['last_modified']) return 0; 
        return ($a['last_modified']<$b['last_modified']) ? -1 : 1; 
}
function cmp_time_desc(&$a, &$b) 
{ 
    if ($a['last_modified']==$b['last_modified']) return 0; 
        return ($a['last_modified']>$b['last_modified']) ? -1 : 1; 
}
function cmp_size_asc(&$a, &$b) 
{ 
    if ($a['size']==$b['size']) return 0; 
        return ($a['size']<$b['size']) ? -1 : 1; 
}
function cmp_size_desc(&$a, &$b) 
{ 
    if ($a['size']==$b['size']) return 0; 
        return ($a['size']>$b['size']) ? -1 : 1; 
}
?>
