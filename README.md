##Sortable Table Plug-in for Moodle

####Note: This is a work in progress

### Installation

1. Clone repo into moodle's /mod/ directory.

2. Require mod/sortableTable.php

3. Create new SortableTable()

### Adding a row

1. Create an assosiative array represnting the row.  Use the header name as the key and the data to be displayed in that column as the value.

2. Pass the array to the table using the add_row($table) function.

