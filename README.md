# New Engen Applicant Interview Challenge -- Lore Sjoberg's Work

This is my implementation of the New Engen challenge, written primarily
in PHP and JavaScript/jQuery. 

The Element class renders both the main layout, and -- through AJAX -- the color swatches.

TwigScribe is our view class, and makes use of the Twig library (included via Composer).

ColorCurator is our database interface (where "database" in this case is the
file "database.json") and allows fluent queries along the lines of
`$colorArray = $this->curator->offset($offset)->limit($this->pageSize)->asArray()->get();`

There are PHPUnit tests included for the PHP scripts

## Implementation

I believe I've accomplished all the goals, including stretch goals and bonus stretch goals, except
for fetching the data via GraphQL.

I added two features not in the spec, each of which added very little time to the project. The
first is a "Clear" button at the bottom of the color family list view, to provide a way
to get back to the starting view. The second is that you can search on the CSS names of the colors
as well as the family and hex value. (The color database is all the CSS colors, and I used the names
to help me sort them into families, then left them in.)

It was unclear to me whether the "tint" swatches should also be clickable into the detail view,
but given that we're specifically running this from a database, I excluded them.

## Time

The project took 10 hours and 40 minutes overall, with the time broken down roughly as follows:

Basic Classes (including unit testing): 1h20m
Refactoring ColorCurator to use fluent query: 1h20m
Layout and CSS: 3h
Basic Page Interaction: 1h20m
Search Functionality: 10m
Pagination: 1h
Responsiveness: 2h
Testing: 30m (I also enlisted a few friends to help me test.)

