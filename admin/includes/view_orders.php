<!-- Include used to view all the order from the orders table - used  order.php - function are in the functions.php page  -->

<div class="col-md-12">
<div class="row">
<h1 class="page-header">All Shop Transactions</h1>
</div>

<div class="row">
<table class="table table-hover">
    <thead>
      <tr>
           <th>Order Id</th>
           <th>Order Date</th>
      </tr>
    </thead>
    <tbody>
	
       <?php dispay_orders() ?>
        
    </tbody>
</table>
</div>
<h2 class="page-header">Food Order Reports</h2>

<table class="table table-hover">

    <thead>

      <tr>
           <th>Order Id</th>
           <th>Food Name</th>
		   <th>Portions Sold</th>
           <th>Product Price at Sale</th>	  
		   <th>Sub Total</th>
		 
      </tr>
    </thead>
    <tbody>
	
    <?php food_from_orders(); ?>
      
</tbody>
</table>

<h2 class="page-header">Drink Order Reports</h2>

<table class="table table-hover">

    <thead>

      <tr>
           <th>Order Id</th>
           <th>Drink Name</th>
		   <th>Portions Sold</th>
           <th>Product Price at Sale</th>	  
		   <th>Sub Total</th>
		 
      </tr>
    </thead>
    <tbody>
	
    <?php drinks_from_orders(); ?>
      
</tbody>
</table>

