<?php
for ($i = 0; $i < 1; $i++) {
?>
<div id="new_row" class="tr<?php echo $i ?>">
    <div class="col-xs-4" style="border:1px solid black;height:25px">
        <select name="sub[]" onchange="handleSubjectChange(<?php echo $i ?>)" required>
            <option></option>
            <?php
            $sql4 = mysqli_query($conn, "SELECT * from SUBJECTS");
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
        <input type="text" style="border-bottom:0px" name="fin[]" class="fina<?php echo $i ?>" readonly>
    </div>
    <div class="col-xs-1 text-center" style="border:1px solid black;height:25px; padding-left:2px;text-align:center;font-size:12px;width:100px">
        <input style="border-bottom:0px" type="text" name="act[]" class="act<?php echo $i ?>" readonly>
    </div>
</div>
<?php } ?>
