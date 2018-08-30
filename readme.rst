Dispatch (Delivery service) APIs document

Here are all the available APIs listed with their functionality and user scope.

• Signup API: For Customer
Any of the customer can easily register by using email, password and
other required fields like first name, last name etc.

• Login API: For Customer and Dispatch both
Any of Customer or Dispatch can login by using their email and
password.

• Place order API: For Customer
Any of Customer can place his order by providing basics order details like
the approx distance (in km), deadline date and time.

• Customer orders API: For Customer
Customer can list and filter the orders. There are three types of orders on
the bases of actions perform by the Dispatch.

	➢ Pending orders: Not accepted or not rejected by Dispatch
	➢ Accepted orders: Accepted by Dispatch
	➢ Rejected orders: Rejected by Dispatch
	➢ Completed orders: Completed by Dispatch

• Add/Edit Pigeons API: For Dispatch
Dispatch will add new pigeon or update existing pigeon with required
details like speed, range etc.

• All orders List API: For Dispatch
Dispatch can list all the Orders list also he can filter Pending orders,
accepted orders, rejected orders and completed orders.

• Pigeons availability and estimate API: For Dispatch
Dispatch can see how many pigeons are available for a particular order
on the bases of order’s distance, deadline date and time and the pigeons
leaves date as well.
Every pigeon will have his estimated cost and time to be complete for
that particular order.Dispatch (Delivery service) APIs document

• Accept order API: For Dispatch
Dispatch can accept an order after checking the pigeons availability for
that. When Dispatch will accept he need to pass order_id and selected
pigeon’s id for that particular order.

• Reject/Complete order API: For Dispatch
Dispatch can Reject an order if he does not found any pigeons
availability. He can not reject already accepted/completed order right
now. At the same movement Dispatch can complete the accepted order
only.

• Add/Remove Pigeon’s Leave API: For Dispatch
Dispatch can add and remove the leaves for the pigeon. He need to
provide the the start date of leave, end date of leave and leave type to
add the leave for a particular Pigeon.
The Pigeon will available for an order in the following cases:
	➢ If the order distance is available within the pigeon’s range
	➢ If the order date does not lies between the any of pigeon’s leaves start date and end date.

• Generate order Invoice API : For Dispatch or Customer both
Customer or Dispatch can generate the invoice details for any of the
completed orders on the bases of selected Pigeon’s calculations
attributes.

Used Response Code List in these APIs:
	✔ Success: 200
	✔ Updated: 205
	✔ Bad Request: 402
	✔ Required: 405



Thanks.
Codeignitor Development Team
TecOrb Technologies Pvt. Ltd.