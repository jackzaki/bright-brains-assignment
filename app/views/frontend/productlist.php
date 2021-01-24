
<a class="btn btn-info" style="float: right; margin: 20px;" href="<?php echo base_url() ?>superadmin" data-toggle="tab"><i class="entypo-plus-circled"></i>Superadmin Login</a>

<a class="btn btn-info" style="float: right; margin: 20px;" href="<?php echo base_url() ?>login" data-toggle="tab"><i class="entypo-plus-circled"></i>User Login | Register</a>

<br><br>

<hr>

<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/frontend/style.css">
<div class="container">
    <h3 class="h3">shopping Demo-1 </h3>
    <div class="row">
       <?php  foreach($productData['Body']['data'] as $row1): ?>
        <div class="col-md-3 col-sm-6">
            <div class="product-grid">
                <div class="product-image">
                    <a href="#">
                        <img  class="pic-1" src="<?php echo base_url(); ?>apis/public/files/<?php echo $row1['picture']; ?>">
                    </a>
                    <ul class="social">
                        <li><a href="" data-tip="Quick View"><i class="fa fa-search"></i></a></li>
                        <li><a href="" data-tip="Add to Wishlist"><i class="fa fa-shopping-bag"></i></a></li>
                        <li><a href="" data-tip="Add to Cart"><i class="fa fa-shopping-cart"></i></a></li>
                    </ul>
                    <span class="product-new-label">Sale</span>
                    <span class="product-discount-label">20%</span>
                </div>
                <ul class="rating">
                    <li class="fa fa-star"></li>
                    <li class="fa fa-star"></li>
                    <li class="fa fa-star"></li>
                    <li class="fa fa-star"></li>
                    <li class="fa fa-star disable"></li>
                </ul>
                <div class="product-content">
                    <h3 class="title"><a href="#"><?php echo $row1['name']; ?></a></h3>
                    <h3 class="title"><a href="#">Color : <?php echo $row1['color']; ?></a></h3>
                    <div class="price"><?php echo $row1['price']; ?>
                        <span><?php echo $row1['price']; ?></span>
                    </div>
                    <a class="add-to-cart" href="">+ Add To Cart</a>
                </div>
            </div>
        </div>
        <?php endforeach;?>
    </div>
</div>
<hr>


<div class="container">
    <h3 class="h3">shopping Demo-2 </h3>
    <div class="row">
    <?php  foreach($productData['Body']['data'] as $row2): ?>
        <div class="col-md-3 col-sm-6">
            <div class="product-grid2">
                <div class="product-image2">
                    <a href="#">
                        <img class="pic-1" src="<?php echo base_url(); ?>apis/public/files/<?php echo $row2['picture']; ?>">
                        <img class="pic-2" src="<?php echo base_url(); ?>apis/public/files/<?php echo $row2['picture']; ?>">
                    </a>
                    <ul class="social">
                        <li><a href="#" data-tip="Quick View"><i class="fa fa-eye"></i></a></li>
                        <li><a href="#" data-tip="Add to Wishlist"><i class="fa fa-shopping-bag"></i></a></li>
                        <li><a href="#" data-tip="Add to Cart"><i class="fa fa-shopping-cart"></i></a></li>
                    </ul>
                    <a class="add-to-cart" href="">Add to cart</a>
                </div>
                <div class="product-content">
                    <h3 class="title"><a href="#"><?php echo $row2['name']; ?></a></h3>
                    <h3 class="title"> Color : <a href="#"><?php echo $row2['color']; ?></a></h3>
                    <span class="price"><?php echo $row2['price']; ?></span>
                </div>
            </div>
        </div>
        <?php endforeach;?>
        
    </div>
</div>
<hr>

<div class="container">
    <h3 class="h3">shopping Demo-3 </h3>
    <div class="row">
    <?php  foreach($productData['Body']['data'] as $row3): ?>
        <div class="col-md-3 col-sm-6">
            <div class="product-grid3">
                <div class="product-image3">
                    <a href="#">
                        <img class="pic-1" src="<?php echo base_url(); ?>apis/public/files/<?php echo $row3['picture']; ?>">
                        <img class="pic-2" src="<?php echo base_url(); ?>apis/public/files/<?php echo $row3['picture']; ?>">
                    </a>
                    <ul class="social">
                        <li><a href="#"><i class="fa fa-shopping-bag"></i></a></li>
                        <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                    </ul>
                    <span class="product-new-label">New</span>
                </div>
                <div class="product-content">
                    <h3 class="title"><a href="#"><?php echo $row3['name']; ?></a></h3>
                    <h3 class="title"><a href="#">Color : <?php echo $row3['color']; ?></a></h3>
                    <div class="price">
                    <?php echo $row3['price']; ?>
                        <span><?php echo $row3['price']; ?></span>
                    </div>
                    <ul class="rating">
                        <li class="fa fa-star"></li>
                        <li class="fa fa-star"></li>
                        <li class="fa fa-star"></li>
                        <li class="fa fa-star disable"></li>
                        <li class="fa fa-star disable"></li>
                    </ul>
                </div>
            </div>
        </div>
        
        <?php endforeach;?>
    </div>
</div>
<hr>

<div class="container">
    <h3 class="h3">shopping Demo-4 </h3>
    <div class="row">
    <?php  foreach($productData['Body']['data'] as $row4): ?>
        <div class="col-md-3 col-sm-6">
            <div class="product-grid4">
                <div class="product-image4">
                    <a href="#">
                        <img class="pic-1" src="<?php echo base_url(); ?>apis/public/files/<?php echo $row4['picture']; ?>">
                        <img class="pic-2" src="<?php echo base_url(); ?>apis/public/files/<?php echo $row4['picture']; ?>">
                        
                    </a>
                    <ul class="social">
                        <li><a href="#" data-tip="Quick View"><i class="fa fa-eye"></i></a></li>
                        <li><a href="#" data-tip="Add to Wishlist"><i class="fa fa-shopping-bag"></i></a></li>
                        <li><a href="#" data-tip="Add to Cart"><i class="fa fa-shopping-cart"></i></a></li>
                    </ul>
                    <span class="product-new-label">New</span>
                    <span class="product-discount-label">-10%</span>
                </div>
                <div class="product-content">
                    <h3 class="title"><a href="#"><?php echo $row4['name']; ?></a></h3>
                    <div class="price">
                        $<?php echo $row4['price']; ?>
                        <span>$<?php echo $row4['price']; ?></span>
                    </div>
                    <a class="add-to-cart" href="">ADD TO CART</a>
                </div>
            </div>
        </div>
        <?php endforeach;?>
        
    </div>
</div>
<hr>

<div class="container">
    <h3 class="h3">shopping Demo-5 </h3>
    <div class="row">
    <?php  foreach($productData['Body']['data'] as $row5): ?>
        <div class="col-md-3 col-sm-6">
            <div class="product-grid5">
                <div class="product-image5">
                    <a href="#">
                        <img class="pic-1" src="<?php echo base_url(); ?>apis/public/files/<?php echo $row5['picture']; ?>">
                        <img class="pic-2" src="<?php echo base_url(); ?>apis/public/files/<?php echo $row5['picture']; ?>">
                        
                    </a>
                    <ul class="social">
                        <li><a href="" data-tip="Quick View"><i class="fa fa-search"></i></a></li>
                        <li><a href="" data-tip="Add to Wishlist"><i class="fa fa-shopping-bag"></i></a></li>
                        <li><a href="" data-tip="Add to Cart"><i class="fa fa-shopping-cart"></i></a></li>
                    </ul>
                    <a href="#" class="select-options"><i class="fa fa-arrow-right"></i> Select Options</a>
                </div>
                <div class="product-content">
                    <h3 class="title"><a href="#"><?php echo $row5['name']; ?></a></h3>
                    <div class="price">$<?php echo $row5['price']; ?></div>
                </div>
            </div>
        </div>
        <?php endforeach;?>
        
    </div>
</div>
<hr>

<div class="container">
    <h3 class="h3">shopping Demo-6 </h3>
    <div class="row">
    <?php  foreach($productData['Body']['data'] as $row6): ?>
        <div class="col-md-3 col-sm-6">
            <div class="product-grid6">
                <div class="product-image6">
                    <a href="#">
                        <img class="pic-1" src="<?php echo base_url(); ?>apis/public/files/<?php echo $row6['picture']; ?>">
                        
                    </a>
                </div>
                <div class="product-content">
                    <h3 class="title"><a href="#"><?php echo $row6['name']; ?></a></h3>
                    <div class="price">$<?php echo $row6['price']; ?>
                        <span>$<?php echo $row6['price']; ?></span>
                    </div>
                </div>
                <ul class="social">
                    <li><a href="" data-tip="Quick View"><i class="fa fa-search"></i></a></li>
                    <li><a href="" data-tip="Add to Wishlist"><i class="fa fa-shopping-bag"></i></a></li>
                    <li><a href="" data-tip="Add to Cart"><i class="fa fa-shopping-cart"></i></a></li>
                </ul>
            </div>
        </div>
        
        <?php endforeach;?>
    </div>
</div>
<hr>

<div class="container">
    <h3 class="h3">shopping Demo-7 </h3>
    <div class="row">
    <?php  foreach($productData['Body']['data'] as $row7): ?>
        <div class="col-md-3 col-sm-6">
            <div class="product-grid7">
                <div class="product-image7">
                    <a href="#">
                        <img class="pic-1" src="<?php echo base_url(); ?>apis/public/files/<?php echo $row7['picture']; ?>">
                        <img class="pic-2" src="<?php echo base_url(); ?>apis/public/files/<?php echo $row7['picture']; ?>">
                        
                    </a>
                    <ul class="social">
                        <li><a href="" class="fa fa-search"></a></li>
                        <li><a href="" class="fa fa-shopping-bag"></a></li>
                        <li><a href="" class="fa fa-shopping-cart"></a></li>
                    </ul>
                    <span class="product-new-label">New</span>
                </div>
                <div class="product-content">
                    <h3 class="title"><a href="#"><?php echo $row7['name']; ?></a></h3>
                    <ul class="rating">
                        <li class="fa fa-star"></li>
                        <li class="fa fa-star"></li>
                        <li class="fa fa-star"></li>
                        <li class="fa fa-star"></li>
                        <li class="fa fa-star"></li>
                    </ul>
                    <div class="price">$<?php echo $row7['price']; ?>
                        <span>$<?php echo $row7['price']; ?></span>
                    </div>
                </div>
            </div>
        </div>
        
        <?php endforeach;?>
    </div>
</div>
<hr>

<div class="container">
    <h3 class="h3">shopping Demo-8 </h3>
    <div class="row">
    <?php  foreach($productData['Body']['data'] as $row8): ?>
        <div class="col-md-4 col-sm-6">
            <div class="product-grid8">
                <div class="product-image8">
                    <a href="#">
                        <img class="pic-1" src="<?php echo base_url(); ?>apis/public/files/<?php echo $row8['picture']; ?>">
                        <img class="pic-2" src="<?php echo base_url(); ?>apis/public/files/<?php echo $row8['picture']; ?>">
                        
                    </a>
                    <ul class="social">
                        <li><a href="" class="fa fa-search"></a></li>
                        <li><a href="" class="fa fa-shopping-bag"></a></li>
                        <li><a href="" class="fa fa-shopping-cart"></a></li>
                    </ul>
                    <span class="product-discount-label">-20%</span>
                </div>
                <div class="product-content">
                    <div class="price">£ <?php echo $row8['price']; ?>
                        <span>£ <?php echo $row8['price']; ?></span>
                    </div>
                    <span class="product-shipping">Free Shipping</span>
                    <h3 class="title"><a href="#"><?php echo $row8['name']; ?></a></h3>
                    <a class="all-deals" href="">See all deals <i class="fa fa-angle-right icon"></i></a>
                </div>
            </div>
        </div>
        <?php endforeach;?>
    </div>
</div>
<hr>

<div class="container">
    <h3 class="h3">shopping Demo-9 </h3>
    <div class="row">
    <?php  foreach($productData['Body']['data'] as $row9): ?>
        <div class="col-md-3 col-sm-6">
            <div class="product-grid9">
                <div class="product-image9">
                    <a href="#">
                        <img class="pic-1" src="<?php echo base_url(); ?>apis/public/files/<?php echo $row9['picture']; ?>">
                        <img class="pic-2" src="<?php echo base_url(); ?>apis/public/files/<?php echo $row9['picture']; ?>">
                        
                    </a>
                    <a href="#" class="fa fa-search product-full-view"></a>
                </div>
                <div class="product-content">
                    <ul class="rating">
                        <li class="fa fa-star"></li>
                        <li class="fa fa-star"></li>
                        <li class="fa fa-star"></li>
                        <li class="fa fa-star"></li>
                        <li class="fa fa-star"></li>
                    </ul>
                    <h3 class="title"><a href="#"><?php echo $row9['name']; ?></a></h3>
                    <h3 class="title">Color : <a href="#"><?php echo $row9['color']; ?></a></h3>
                    <div class="price"> <?php echo $row9['price']; ?></div>
                    <a class="add-to-cart" href="">VIEW PRODUCTS</a>
                </div>
            </div>
        </div> 
        <?php endforeach;?>
    </div>
</div>
<hr>