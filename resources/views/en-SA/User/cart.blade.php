<?php include('header.php'); ?>

<section class="inner_banner" style="background: url('images/bg_3.jpg') no-repeat;background-position: center;background-size: cover;background-position: 50% 90%;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="vl-filter-text-box">
                    <h1>Cart</h1>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="shopping-cart spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-8 col-sm-12">
                    <div class="table-responsive cart-table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th class="p-name">Product Name</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th>X</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="cart-pic first-row"><img src="images/menu/small.jpg" alt=""></td>
                                    <td class="cart-title first-row">
                                        <h5>Product name</h5>
                                    </td>
                                    <td class="p-price first-row">$20</td>
                                    <td class="qua-col first-row">
                                        <div class="quantity">
                                            <div class="pro-qty"><span class="dec qtybtn">-</span>
                                                <input type="text" value="1">
                                            <span class="inc qtybtn">+</span></div>
                                        </div>
                                    </td>
                                    <td class="total-price first-row">$20</td>
                                    <td class="close-td first-row"><a href="javascript:void(0);">X</a></td>
                                </tr>
                                <tr>
                                    <td class="cart-pic"><img src="images/menu/small.jpg" alt=""></td>
                                    <td class="cart-title">
                                        <h5>Product name</h5>
                                    </td>
                                    <td class="p-price">$20</td>
                                    <td class="qua-col">
                                        <div class="quantity">
                                            <div class="pro-qty"><span class="dec qtybtn">-</span>
                                                <input type="text" value="1">
                                            <span class="inc qtybtn">+</span></div>
                                        </div>
                                    </td>
                                    <td class="total-price">$20</td>
                                    <td class="close-td"><a href="javascript:void(0);">X</a></td>
                                </tr>
                                <tr>
                                    <td class="cart-pic"><img src="images/menu/small.jpg" alt=""></td>
                                    <td class="cart-title">
                                        <h5>Product name</h5>
                                    </td>
                                    <td class="p-price">$20</td>
                                    <td class="qua-col">
                                        <div class="quantity">
                                            <div class="pro-qty"><span class="dec qtybtn">-</span>
                                                <input type="text" value="1">
                                            <span class="inc qtybtn">+</span></div>
                                        </div>
                                    </td>
                                    <td class="total-price">$20</td>
                                    <td class="close-td"><a href="javascript:void(0);">X</a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="">
                            <div class="discount-coupon">
                                <h6>Discount Codes</h6>
                                <form action="#" class="coupon-form">
                                    <input type="text" placeholder="Enter your codes">
                                    <button type="submit" class="site-btn coupon-btn">Apply</button>
                                </form>
                            </div>
                        </div>
                        <div class="">
                            <h6>Cart Totals</h6>
                            <div class="proceed-checkout">
                                <ul>
                                    <li class="subtotal">Subtotal <span>$240.00</span></li>
                                    <li class="cart-total">Total <span>$240.00</span></li>
                                </ul>
                                <a href="#" class="btn btn-primary w-100">PROCEED TO CHECK OUT</a>
                            </div>
                        </div>
                    </div>

            </div>
        </div>
    </section>


<?php include('footer.php'); ?>