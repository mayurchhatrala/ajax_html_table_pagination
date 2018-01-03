<!DOCTYPE html>
<html>
<head>
    <title>Student</title>

    <link rel="stylesheet" type="text/css" href="<?= ASSET_URL ?>css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?= ASSET_URL ?>style.css">
    <script type="text/javascript" src="<?= ASSET_URL ?>jquery.min.js"></script>
    <script type="text/javascript" src="<?= ASSET_URL ?>js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?= ASSET_URL ?>jquery.validate.min.js"></script>

</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="form_main">
                <h4 class="heading"><strong>Quick </strong> Contact <span></span></h4>
                <div class="form">
                    <?php echo form_open('/', array("id" => "contactFrm", "name" => "contactFrm")); ?>
                        <input type="text" required="" placeholder="Please input your firstname" value="" name="firstname" class="txt">
                        <input type="text" required="" placeholder="Please input your lastname" value="" name="lastname" class="txt">

                        <select id="stud" name="stud">
                            <option value="">Select Standard</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                        </select>

                        <input type="text" required="" placeholder="Please input maths marks" value="" name="mathsmarks" class="txt">
                        <input type="text" required="" placeholder="Please input science marks" value="" name="sciencemarks" class="txt">
                        <input type="text" required="" placeholder="Please input english marks" value="" name="englishmarks" class="txt">
                        
                        <input type="submit" value="submit" name="submit" class="txt2">
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

$(function() {

        $("#contactFrm").validate({
            rules: {
                firstname: "required",
                lastname: "required",
                stud:"required",
                mathsmarks: {
                    "required" : true,
                    "max":100
                },
                sciencemarks: {
                    "required" : true,
                    "max":100
                },
                englishmarks: {
                    "required" : true,
                    "max":100
                },
            },
            messages: {
                firstname: "Please enter your firstname",
                lastname: "Please enter your lastname",
                stud: "please select standard",
                mathsmarks: {
                    "required" : "pelase enter the marks",
                    "max": "marks should be less then 100"
                },
                sciencemarks: {
                    "required" : "pelase enter the marks",
                    "max": "marks should be less then 100"
                },
                englishmarks: {
                    "required" : "pelase enter the marks",
                    "max": "marks should be less then 100"
                },
            },
            submitHandler: function (form) {

                $.ajax({
                    url: "<?= BASE_URL?>"+ "welcome/addData", 
                    type: "POST",             
                    data: $('#contactFrm').serialize(),
                    cache: false,             
                    processData: false,          
                    success: function(data) {
                        console.log(data);
                    }
                });
                
            }
        });

 });
</script>

</body>
</html>