***Logic***
1. Configure Strap in NGREST
2. NGREST stores strap identifier hash into session
3. NGREST delivers NG-CRUD
4. click on Strap Button in NG-CRUD; requests the strap based on the identifier
5. Strap class will be loaded based on the identifier
6. Casual Ajax requests between strap <-> NG-CRUD strap container


__construct
------------

Strap classed allows to have a custom __construct() method to required arguments.