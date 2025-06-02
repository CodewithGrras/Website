<?php 
	  $frequently_asked_questions_new = get_field('frequently_asked_questions_new');
    $frequently_asked_questions = get_field('frequently_asked_questions');

    $faqs = !empty($frequently_asked_questions_new) ? $frequently_asked_questions_new : $frequently_asked_questions;
    if(!empty($faqs)) { ?>
?>
    <section class="faqs scroller" id="faqsec" data-anchor="faqsec">
      <div class="container wow fadeInUp">
        <div class="row justify-content-center">
          <div class="col-md-12">
            <h2>Frequently Asked Questions</h2>
          </div>
        </div>
         <?php 
         
         $frequently_asked_questions_new = get_field('frequently_asked_questions_new'); ?>
        <div class="row">
          	<div class="col-lg-4 d-none d-md-block">
	            <ul class="nav left-tab mt-0" id="myTab" role="tablist">
	                <?php 
	                foreach($frequently_asked_questions_new as $index => $item){
	                ?>
	              <li class="nav-item" role="presentation">
	                <a href="#" class="nav-link <?php echo $index == 0 ? 'active' : ''?>" id="<?php slug_custom($item['category']) ?>-tab" data-bs-toggle="tab" data-bs-target="#<?php slug_custom($item['category']) ?>-tab-pane" role="tab" aria-controls="<?php slug_custom($item['category']) ?>-tab-pane" aria-selected="false"><?php echo($item['category']) ?> (<?php echo count($item['question_and_answer']) ?>)</a>
	              </li>
	              <?php } ?>
	           
	            </ul>
	          </div>
          <div class="col-lg-8 d-none d-md-block">
            <div class="tab-content" id="myTabContent">
                <?php 
	                foreach($frequently_asked_questions_new as $index => $item){
	                ?>
	                
	              <div class="tab-pane fade show <?php echo $index == 0 ? 'active' : ''?>" id="<?php slug_custom($item['category']) ?>-tab-pane" role="tabpanel" aria-labelledby="<?php slug_custom($item['category']) ?>-tab" tabindex="<?php echo $index; ?>">
                <div class="accordion" id="accordionExample<?php echo $index;?>">
                    <?php foreach($item['question_and_answer'] as $index2 => $sub_item): ?>
                  <div class="accordion-item">
                    <h4 class="accordion-header" id="heading<?php echo $index2; ?>">
                      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $index2; ?>" aria-expanded="false" aria-controls="collapse<?php echo $index2; ?>">
                        <?php echo $sub_item['question']; ?>
                      </button>
                    </h4>
                    <div id="collapse<?php echo $index2; ?>" class="accordion-collapse collapse" aria-labelledby="heading<?php echo $index2; ?>" data-bs-parent="#accordionExample<?php echo $index; ?>">
                      <div class="accordion-body">
                        <p> <?php echo $sub_item['answer']; ?></p>
                      </div>
                    </div>
                  </div>
                  <?php endforeach; ?>
                </div>
              </div>
           
	              <?php } ?>
             </div>
          </div>
          <div class="col-lg-12 d-block d-md-none">
    <div class="accordion" id="accordionExample2">
        <?php foreach ($frequently_asked_questions_new as $index => $item) { ?>
            <div class="accordion-item">
                <h4 class="accordion-header" id="heading11<?php echo $index; ?>">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse11<?php echo $index; ?>" aria-expanded="false" aria-controls="collapse11<?php echo $index; ?>">
                        <?php echo $item['category']; ?> (<?php echo count($item['question_and_answer']); ?>)
                    </button>
                </h4>
                <div id="collapse11<?php echo $index; ?>" class="accordion-collapse collapse" aria-labelledby="heading11<?php echo $index; ?>" data-bs-parent="#accordionExample2">
                    <div class="accordion-body">
                        <div class="accordion" id="nestedAccordion<?php echo $index; ?>">
                            <?php foreach ($item['question_and_answer'] as $index2 => $sub_item) { ?>
                                <div class="accordion-item">
                                    <h4 class="accordion-header" id="nestedHeading<?php echo $index . '-' . $index2; ?>">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#nestedCollapse<?php echo $index . '-' . $index2; ?>" aria-expanded="false" aria-controls="nestedCollapse<?php echo $index . '-' . $index2; ?>">
                                            <?php echo $sub_item['question']; ?>
                                        </button>
                                    </h4>
                                    <div id="nestedCollapse<?php echo $index . '-' . $index2; ?>" class="accordion-collapse collapse" aria-labelledby="nestedHeading<?php echo $index . '-' . $index2; ?>" data-bs-parent="#nestedAccordion<?php echo $index; ?>">
                                        <div class="accordion-body">
                                            <p><?php echo $sub_item['answer']; ?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

        </div>
      </div>
    </section
    
 <a  href="javascript:void(0)" class="btn btn-primary"  data-bs-toggle="modal" data-bs-target="#exampleModal5"  ></a>

 <?php } ?>