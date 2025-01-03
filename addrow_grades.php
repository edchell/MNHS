<?php
session_start(); 
include('auth.php');
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        // Hide initial row setup
        $("#new_row").hide();

        // Clone the initial row on button click and show it
        $("#new_add").click(function() {
            $("#new_row").clone().appendTo("#t_rows").show();
            disableSubject();  // Ensure the disablement applies to new row as well
        });
    });

    // Function to disable subjects already selected in other dropdowns
    function disableSubject() {
        let selects = document.querySelectorAll("select");
        let selectedValues = [];

        // Collect selected values from all select elements
        selects.forEach(select => {
            let selectedOption = select.options[select.selectedIndex];
            if (selectedOption.value) {
                selectedValues.push(selectedOption.value);
            }
        });

        // Enable all options first
        selects.forEach(select => {
            for (let option of select.options) {
                option.style.display = 'block';
            }
        });

        // Disable the selected options in other dropdowns
        selects.forEach(select => {
            for (let option of select.options) {
                if (selectedValues.includes(option.value) && option.value !== "") {
                    option.style.display = 'none';
                }
            }
        });
    }

    // Function to handle changes in subject selection
    function handleSubjectChange() {
        disableSubject(); // Reapply disablement across all dropdowns
    }

    // Custom function to add a new row with disablement functionality integrated
    function newrow($i) {
        var i = $i + 1;
        var data = '<div id="new_row" class="tr' + i + '" >' +
            '<div class="col-xs-4" style="border:1px solid black;height:25px">' +
            '<select name="sub[]" onchange="handleSubjectChange()" required>' +  // Call handleSubjectChange on selection
            '<option></option>' +
            '<?php
                $sql4 = mysqli_query($conn, "SELECT * from subjects");
                while ($row4 = mysqli_fetch_assoc($sql4)) {
                    ?>' +
                    '<option value="<?php echo $row4['SUBJECT_ID']; ?>"><?php echo $row4['SUBJECT']; ?></option>' +
                    '<?php
                }
            ?>' +
            '</select>' +
            '</div>' +
            '<div class="col-xs-4" style="border:1px solid black;width:59px;height:25px;font-size:12px; padding-left:5px;">' +
            '<input type="text" style="border-bottom:0px" name="una[]" onkeyup="ave2(' + i + ')" onkeydown="ave2(' + i + ')" class="grad' + i + '" oninput="validateNumber(event)">' +
            '</div>' +
            '<div class="col-xs-4" style="border:1px solid black;width:56px;height:25px;font-size:12px; padding-left:5px;">' +
            '<input type="text" style="border-bottom:0px" name="duwa[]" onkeyup="ave2(' + i + ')" onkeydown="ave2(' + i + ')" class="grad' + i + '" oninput="validateNumber(event)">' +
            '</div>' +
            '<div class="col-xs-4" style="border:1px solid black;width:56px;height:25px;font-size:12px; padding-left:5px;">' +
            '<input type="text" style="border-bottom:0px" name="tatlo[]" onkeyup="ave2(' + i + ')" onkeydown="ave2(' + i + ')" class="grad' + i + '" oninput="validateNumber(event)">' +
            '</div>' +
            '<div class="col-xs-4" style="border:1px solid black;width:54px;height:25px;font-size:12px; padding-left:5px;">' +
            '<input type="text" style="border-bottom:0px" name="apat[]" onkeyup="ave2(' + i + ')" onkeydown="ave2(' + i + ')" class="grad' + i + '" oninput="validateNumber(event)">' +
            '</div>' +
            '<div class="col-xs-1 text-center" style="font-size:12px;border:1px solid black;height:25px;padding-left:1px">' +
            '<input type="text" style="border-bottom:0px" name="fin[]" id="fina' + i + '" readonly>' +
            '</div>' +
            '<div class="col-xs-1 text-center" style="border:1px solid black;height:25px; padding-left:2px;text-align:center;font-size:12px;width:100px">' +
            '<input style="border-bottom:0px" type="text" name="act[]" id="act' + i + '" readonly>' +
            '</div>' +
            '</div>';
        
        $('#t_rows').append(data);
        disableSubject();  // Reapply disablement after new row is added
    }
</script>

<?php
for ($i = 0; $i < 1; $i++) {
?>
<div id="new_row" class="tr<?php echo $i ?>">
    <div class="col-xs-4" style="border:1px solid black;height:25px">
        <select name="sub[]" onchange="handleSubjectChange()" required>
            <option></option>
            <?php
            $sql4 = mysqli_query($conn, "SELECT * from subjects");
            while ($row4 = mysqli_fetch_assoc($sql4)) {
            ?>
                <option value="<?php echo $row4['SUBJECT_ID']; ?>"><?php echo $row4['SUBJECT']; ?></option>
            <?php
            }
            ?>
        </select>
    </div>
    
    <div class="col-xs-4" style="border:1px solid black;width:59px;height:25px;font-size:12px; padding-left:5px;">
        <input type="text" style="border-bottom:0px" name="una[]" onkeyup="ave2(<?php echo $i ?>)" onkeydown="ave2(<?php echo $i ?>)" class="grad<?php echo $i ?>" oninput="validateNumber(event)" required>
    </div>
    <div class="col-xs-4" style="border:1px solid black;width:56px;height:25px;font-size:12px; padding-left:5px;">
        <input type="text" style="border-bottom:0px" name="duwa[]" onkeyup="ave2(<?php echo $i ?>)" onkeydown="ave2(<?php echo $i ?>)" class="grad<?php echo $i ?>" oninput="validateNumber(event)" required>
    </div>
    <div class="col-xs-4" style="border:1px solid black;width:56px;height:25px;font-size:12px; padding-left:5px;">
        <input type="text" style="border-bottom:0px" name="tatlo[]" onkeyup="ave2(<?php echo $i ?>)" onkeydown="ave2(<?php echo $i ?>)" class="grad<?php echo $i ?>" oninput="validateNumber(event)" required>
    </div>
    <div class="col-xs-4" style="border:1px solid black;width:54px;height:25px;font-size:12px; padding-left:5px;">
        <input type="text" style="border-bottom:0px" name="apat[]" onkeyup="ave2(<?php echo $i ?>)" onkeydown="ave2(<?php echo $i ?>)" class="grad<?php echo $i ?>" oninput="validateNumber(event)" required>
    </div>
    <div class="col-xs-1 text-center" style="font-size:12px;border:1px solid black;height:25px;padding-left:1px">
        <input type="text" style="border-bottom:0px" name="fin[]" id="fina<?php echo $i ?>" readonly>
    </div>
    <div class="col-xs-1 text-center" style="border:1px solid black;height:25px; padding-left:2px;text-align:center;font-size:12px;width:100px">
        <input style="border-bottom:0px" type="text" name="act[]" id="act<?php echo $i ?>" readonly>
    </div>
</div>
<?php } ?>

<script>
    function validateNumber(event) {
    const input = event.target;
    input.value = input.value.replace(/[^0-9]/g, ''); // Remove anything that's not a number
}
</script>