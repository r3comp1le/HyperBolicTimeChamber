<?php
include('../template.php');
?>

<!-- Start Content HERE -->  
<div class="container-fluid" role="main">

    <form name="frm1" action="index.php" method="post">
        <textarea name="txt1" width="100%" class="frm1" id="frm1" placeholder="Blob of Text"></textarea>
        <input class="form-control input-xxlarge" name="ref" size="50" placeholder="http://www.reference.paste/here.html" type="text">
        <select class="form-control" name="source">
          <option>Source 1</option>
          <option>Source 2</option>
          <option>Source 3</option>
          <option>Source 4</option>
          <option>Source 5</option>
        </select><br>
        <input class="btn btn-primary" type="submit" value="Convert" >
    </form>
    
    <div id="filter-bar"> </div>
    <table data-toggle="table" data-classes="table table-hover table-condensed" data-striped="true" data-show-columns="true" data-search="true" data-show-refresh="true" data-toolbar="#filter-bar" data-show-toggle="true" data-show-filter="true" data-pagination="false" data-show-export="true">

    <thead>
        <tr>
    <th data-field="obtype" data-sortable="true">Object Type</th> 
    <th data-field="vals" data-sortable="true">Value</th>
    <th data-field="src" data-sortable="true">Source</th>
    <th data-field="meth" data-sortable="false">Method</th>
    <th data-field="ref" data-sortable="false">Reference</th>
    <th data-field="add" data-sortable="false">Add Indicator</th>
    <th data-field="del" data-sortable="false">Delete</th>
        </tr>
    </thead>
    <tbody>
    <?php
    $ip_regex = '/(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)/';
    $url_regex = '/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\.\-\_]+\.[a-zA-Z0-9]{1,3}(\/\S*)?/';
    $email_regex = '/[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+.[a-zA-Z0-9-.]+/';
    $domain_regex ='/((?=[a-z0-9-]{1,63}\.)(xn--)?[a-z0-9]+(-[a-z0-9]+)*\.)+[a-z]{2,63}/i';

    if(isset($_POST["txt1"]))
    {

        $ref = $_POST["ref"];
        $source = $_POST["source"];

        $data = $_POST["txt1"];
        $lines1 = str_replace("hxxp", "http", $data );
        $lines2 = str_replace("hxxps", "https", $lines1 );
        $lines3 = str_replace("[.]", ".", $lines2 );
        $lines4 = str_replace("\"", " ", $lines3 );
        $lines5 = str_replace("[dot]", ". ", $lines4 );
        $lines6 = str_replace("[@]", "@", $lines5 );
        $lines7 = str_replace("www.", "", $lines6 );

        preg_match_all($domain_regex, $lines7, $domArray);
        preg_match_all($ip_regex , $lines7, $ipArray);
        preg_match_all($url_regex, $lines7, $urlArray);
        preg_match_all($email_regex, $lines7, $emailArray);

        if(!empty($domArray))
        {
            foreach ($domArray[0] as $dom)
            {
                print "<tr><td>Domain</td><td>".$dom."</td><td>".$source."</td><td></td><td>".$ref."</td><td>true</td><td class='deleterow'><div class='glyphicon glyphicon-remove'></div></td></tr>";
            }
        }
        if(!empty($ipArray))
        {
            foreach ($ipArray[0] as $ip)
            {
                print "<tr><td>IPv4 Address</td><td>".$ip."</td><td>".$source."</td><td></td><td>".$ref."</td><td>true</td><td class='deleterow'><div class='glyphicon glyphicon-remove'></div></td></tr>";
            }
        }
        if(!empty($urlArray))
        {
            foreach ($urlArray[0] as $url)
            {
                print "<tr><td>C2 URL</td><td>".$url."</td><td>".$source."</td><td></td><td>".$ref."</td><td>true</td><td class='deleterow'><div class='glyphicon glyphicon-remove'></div></td></tr>";
            }
        }
        if(!empty($emailArray))
        {
            foreach ($emailArray[0] as $email)
            {
                print "<tr><td>Email Address</td><td>".$email."</td><td>".$source."</td><td></td><td>".$ref."</td><td>true</td><td class='deleterow'><div class='glyphicon glyphicon-remove'></div></td></tr>";
            }
        }
    }
    ?>
    </tbody>
    </table>
    
</div>

<script>
(function($) {
        $(document).ready(function() 
        { 
        $(".deleterow").click(function(){
        var $killrow = $(this).parent('tr');
        $killrow.addClass("danger");
            $killrow.fadeOut(1000, function(){
            $(this).remove();
            });
        });
    }); 
})(jQuery);
</script>
    
</body>
</html>