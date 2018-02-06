<!doctype html>
<html lang="en" class="no-js">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700' rel='stylesheet' type='text/css'>

    <link rel="stylesheet" href="js/mixit/css/reset.css"> <!-- CSS reset -->
    <link rel="stylesheet" href="js/mixit/css/style.css"> <!-- Resource style -->
    <link rel="stylesheet" href="css/app.css">


    <title>Oddity - Content Filters</title>
</head>
<body>
<header class="cd-header">
    <h1>Oddity - Content Filters</h1>
</header>

<main class="cd-main-content">


    <section class="cd-gallery" >

        <table id="content">

            <thead>
            <tr>
                <th>Url Image</th>
                <th>Post Date</th>
                <th>Amount of Likes</th>
                <th>Amount of Comments</th>
                <th>Comments List</th>
                <th>User Like List</th>

            </tr>
            </thead>

            <tbody>


            </tbody>


        </table>


    </section> <!-- cd-gallery -->

    <div class="cd-filter">
        <form id="filterForm">


            <div class="cd-filter-block">
                <h4>Date Range</h4>


                <div class='picker cd-filter-content'>

                    <div>
                        <label for="fromperiod">From</label>
                        <input type="date" name="fromDate">

                    </div>

                    <div>
                        <label for="toperiod">to</label>
                        <input type="date" name="toDate" >
                    </div>

                </div>


            </div> <!-- cd-filter-block -->

            <div class="cd-filter-block">
                <h4>Sorting</h4>


                <div class='picker cd-filter-content'>

                    <div>
                        <label for="fromperiod">Field</label>

                        <div class="cd-select cd-filters">
                            <select class="filter" name="sortingField">
                                <option value="">Choose an option</option>
                                <option value="amount_likes">Number of likes</option>
                                <option value="amount_comments">Number of comments</option>
                                <option value="postdate">Post Date</option>

                            </select>
                        </div> <!-- cd-select -->

                    </div>

                    <div>
                        <label for="toperiod">Order</label>


                        <div class="cd-select cd-filters">
                            <select class="filter" name="sortingOrder">
                                <option value="">Choose an option</option>
                                <option value="asc">Ascending</option>
                                <option value="desc">Descending</option>


                            </select>

                        </div>

                    </div>


            </div> <!-- cd-filter-block -->
            </div>

            <div>

                <input class='button' type="submit" name="submit" value="Submit">

            </div>



        </form>

        <a href="#0" class="cd-close">Close</a>
    </div> <!-- cd-filter -->

    <a href="#0" class="cd-filter-trigger">Filters</a>
</main> <!-- cd-main-content -->
<script src="js/jquery-2.1.1.js"></script>
<script src="js/mixit/js/modernizr.js"></script> <!-- Modernizr -->
<script src="js/mixit/js/jquery.mixitup.min.js"></script>
<script src="js/mixit/js/main.js"></script> <!-- Resource jQuery -->
<script src="js/filter.js"></script> <!-- Resource jQuery -->





</body>
</html>