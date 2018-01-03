<!DOCTYPE html>
<html>
<head>
    <title>Student</title>

    <link rel="stylesheet" type="text/css" href="<?= ASSET_URL ?>css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?= ASSET_URL ?>style.css">
    <script type="text/javascript" src="<?= ASSET_URL ?>jquery.min.js"></script>
    <script type="text/javascript" src="<?= ASSET_URL ?>js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
    <div class="row mylist" id="mylist">
        <div class="col-md-8 col-md-offset-2">
            <div class="form_main">
                <h4 class="heading"><strong>Student </strong> List <span></span></h4>
                <div class="form" id="studentlisting">

                    <select id="maxlimit" class="select">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="50">50</option>
                    </select>

                    <div class="pull-right">
                        <select class="select" id="filtertype" name="filtertype">
                            <option value="name">Name</option>
                        </select>
                        <input type="text" class="txt2" id="search" name="search" placeholder="search">
                        <input type="button" id="filterBtn" class="btn btn-info" value="Filter">
                    </div>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Standard</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Maths</th>
                                <th>Science</th>
                                <th>English</th>
                                <th>Total Marks</th>
                                <th>Result</th>
                                <th>Pass in Subject</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>

                    <div class="pagination"></div>

                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

$(function() {

    var newlimit = 5;

    var studentList = function(){

        $.ajax({
            url: "<?= BASE_URL?>"+ "welcome/getStudentList", 
            type: "POST",             
            data: {"limit":newlimit},
            dataType: "json",
            cache: false,
            success: function(data) {
                // data = JSON.parse(data);
                if(data.STATUS == 200){
                    getTableHtml(data.DATA);
                }
            }
        });
    }

    var getTableHtml = function(datarow){
        var newhtml = '';

        $.each(datarow.DATA, function(key,val){

            newhtml += '<tr>';
                newhtml += "<td>" + val.stud + "</td>";
                newhtml += "<td>" + val.firstname + "</td>";
                newhtml += "<td>" + val.lastname + "</td>";
                newhtml += "<td>" + val.maths + "</td>";
                newhtml += "<td>" + val.science + "</td>";
                newhtml += "<td>" + val.english + "</td>";
                newhtml += "<td>" + val.total_marks + "</td>";
                newhtml += "<td>" + val.result + "</td>";
                newhtml += "<td>" + val.total_pass + "</td>";
            newhtml += '</tr>';
        });

        var pagiHtml = '<div> Current Page: '+ (datarow.current_page+1) +'</div>';
        pagiHtml += '<div> Total Record: '+ (datarow.total_record) +'</div>';
        for (var i = 0 ; i < datarow.per_page; i++) {
            pagiHtml += "<a id='"+i+"' class='paginationBtn' >"+ (i+1) +"</a> &nbsp;";
        }
        
        $(".table tbody").html(newhtml);
        $(".pagination").html(pagiHtml);
        $('.pagination').attr('id', datarow.current_page);
    }

    $('body').on('click', 'a.paginationBtn', function() {
        var pageid = this.id;
        var currentid = $('.pagination').attr('id');

        if(currentid != pageid){
            $.ajax({
                url: "<?= BASE_URL?>"+ "welcome/getStudentList", 
                type: "POST",             
                data: {"pageid":pageid, "limit":newlimit},
                dataType: 'json',
                success: function(res) {
                    if(res.STATUS == 200){
                        getTableHtml(res.DATA);
                    }
                }
            });
        }
    });

    $('body').on('change', '#maxlimit', function() {
        newlimit = this.value;
        $.ajax({
            url: "<?= BASE_URL?>"+ "welcome/getStudentList", 
            type: "POST",             
            data: {"limit":newlimit},
            dataType: 'json',
            success: function(res) {
                if(res.STATUS == 200){
                    getTableHtml(res.DATA);
                }
            }
        });
    });

    $('body').on('click', '#filterBtn', function() {

        var filtertype = $("#filtertype").val();
        var filterVal = $("#search").val();

        if(filterVal != ''){
            $.ajax({
                url: "<?= BASE_URL?>"+ "welcome/getStudentList", 
                type: "POST",             
                data: {"key":filtertype, "search":filterVal},
                dataType: 'json',
                success: function(res) {
                    if(res.STATUS == 200){
                        getTableHtml(res.DATA);
                    }
                }
            });
        }
    });

    // get student list when page load
    studentList();

});


</script>

</body>
</html>