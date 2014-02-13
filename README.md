##Sortable Table Plug-in for Moodle

####Note: This is a work in progress

### Installation

1. Clone repo into moodle's /mod/ directory.

2. Require mod/sortableTable.php

3. Create new SortableTable()

### Adding a row

1. Create an assosiative array represnting the row.  Use the header name as the key and the data to be displayed in that column as the value.

2. Pass the array to the table using the add_row($row) function.

### Adding a column header

This function is not required.  And header included in a row will automatically be added to the table.

1. Pass the name of the desired column header to the table using the add_header($string) function.

### Printing table page

Simply call the print_table() function to echo the table onto the page.

#####OR

1. Call generate_external_includes() to add scripts to the page

2. Call generate_dataset() to have a string representation of the dataset returned.  (Note: this is a javascript dataset).

3. Call generate_table_script() to have a string representation of the table building script returned.  (Note: this is javascript).
