<?php

// Add Tutor's Subjects Admin Menu
function code_list_call_function_for_admin_widget_menu()
{
    add_menu_page(
        'Tiny Schoolars', // Page title
        'Tiny Schoolars', // Menu title
        'manage_options',    // Capability required to access the menu
        'tiny-schoolars',   // Menu slug
        'code_list_page_content', // Callback function to display the page content
        'dashicons-flag',    // Icon for the menu (you can choose from Dashicons: https://developer.wordpress.org/resource/dashicons/)
        9                   // Menu position
    );
    // add_submenu_page('tiny-schoolars', 'Reset The Database', 'Reset The databse', 'manage_options', 'reset-database', 'reset_database', 100);
}
add_action('admin_menu', 'code_list_call_function_for_admin_widget_menu');

// Callback function to display the page content


function code_list_page_content()
{
?>
    <div class="wrap">
        <h2>Tiny Schoolars</h2>
        <link rel="stylesheet" href="https://cdn.datatables.net/2.0.2/css/dataTables.dataTables.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">




        <div class="subject-container">
            <div class="container">
                    <div class="loading-container">
                        <div class="loading"></div>
                    </div>

                    <div class="backend-view">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <h3>
                                        Admin Menu Content Will go here!
                                    </h3>
                                </div>
                            </div>
                        </div>


                    </div>

                    <script src='https://code.jquery.com/jquery-3.7.1.min.js' integrity='sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=' crossorigin='anonymous'></script>
                    <script src="https://kit.fontawesome.com/46882cce5e.js" crossorigin="anonymous"></script>
                </body>
            </div>
        </div>
    </div>

<?php
}

