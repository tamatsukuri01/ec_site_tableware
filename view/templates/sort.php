<select name="sort">
    <option value="new" <?php if((isset($sort)) && $sort === "new") {echo 'selected' ;} ?>>新着順</option>
    <option value="cheap" <?php if((isset($sort)) && $sort === "cheap") {echo 'selected' ;} ?>>価格が安い順</option>
    <option value="high" <?php if((isset($sort)) && $sort === "high") {echo 'selected' ;} ?>>価格が高い順</option>
</select>
