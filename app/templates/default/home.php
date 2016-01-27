<?php $this->layout('layout', ['title' => 'Accueil']) ?>
	

<?= $this->start('header') ?>


<div class="container-fluid" id="header">

	<div id="series-carousel" class="carousel container slide">
  		<div class="carousel-inner">
          <div class="active item one"></div>
          <div class="item two"></div>
          <div class="item three"></div>
          <div class="item four"></div>
      </div>

<!-- carousel -->
<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
  <!-- Wrapper for slides -->
  <div class="carousel-inner" role="listbox">
    <div class="item active">
      <img src="<?= $this->assetUrl('img/got1.png') ?>" alt="Game of Throne">
      <div class="carousel-caption">
      </div>
    </div>
    <div class="item">
      <img src="<?= $this->assetUrl('img/orangebg.jpg') ?>" alt="Orange is the new black">
      <div class="carousel-caption">
      </div>
    </div>
    <div class="item">
      <img src="<?= $this->assetUrl('img/sunny.jpg') ?>" alt="It's always sunny in Philadelphia">
      <div class="carousel-caption">
      </div>
    </div>

  </div>
</div>

<?= $this->stop('header') ?>

<?php $this->start('main_content') ?>
	



 
 
<?php $this->stop('main_content') ?>
