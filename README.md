 #### Project Idea

1. Two user type
        - User
        - Parmecy
    
2. To registration
        - Name
        - Email
        - Password
        - Address
        - Dob
        - Contact Number
    
3. Loging using 
        - Email
        - Password

4. User can create req 
        - 5 images
        - Note
        - Delivery Address

5. Parmecy can reply, view, make quatation for the uploaded pres

        admin can give a comment only if there is no drugs according to the req

6. After updated user can get the notification via email


### Table Structure

1. Prescriptions
    - Delivery Address (String){Req}
    - Attacthments (json){Req}
    - Note (Text){nullable}
    - User_Id{Req}
    - Status (Open{Defult}, Accepted, Rejected )
    - Status_changed_by_id{nullable}

2. Replys
    - body (Text){nullable}
    - drug (String){Req}
    - Quantity (int){Req}
    - User_id
    - Prescription_id{Req}




