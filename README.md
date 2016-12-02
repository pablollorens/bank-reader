# bank-reader
Parser of excel files with bank transactions

# Installation
1) Clone repository and run composer.
    ```
    > git clone https://github.com/pablollorens/bank-reader
    > composer install
    ```

2) Configure parameters in /app/config/parameters.yml
    ```
    data_folder: '/web/data'
    
    excel:
        transaction_date_column: 'C'
        amount_column: 'G'
        description_column: 'H'
    
    categories:
        - category_1: ["keyword_1_1", "keyword_1_2", "keyword_1_3"]
        - category_2: ["keyword_2_1", "keyword_2_2", "keyword_2_3"]
    ```    

3) Download the excel file(s) with the transactions from your bank and place them in /web/data or any other folder that you may have configured in step 2.

4) Initiate the web service, for instance, using the PHP built-in server.
    ```
    php -S 0.0.0.0:8000 -t web
    ```

# Instructions
- The index view is a graph to explore the expenses. You can comment those categories that you would like to remove from this graph.
- There is a path to explore in detail the expenses per month. For this you should write in your browser:
    ```
    http://localhost:8000/explore/YYYY-mm in your browser
    ```
