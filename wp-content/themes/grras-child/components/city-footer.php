<div class="container d-none d-md-block mb-4">
    <h4 class="text-white">Trainings in Other Cities</h4>

    <div class="courses-list">
        <?php
        $cities = get_terms('city');
        foreach ($cities as $city) {
            ?>
            <a href="<?php echo get_term_link($city)?>">Courses in <?php echo $city->name; ?> |</a>
            <?php
        }
        ?>
    </div>
<p style="border-top: 1px #3b3b3b solid;
"></p>
</div>