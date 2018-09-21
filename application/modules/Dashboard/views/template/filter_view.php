<div class="navbar navbar-inverse">
  <div class="container">
    <div class="navbar-collapse collapse" id="navbar-filter">
      <div class="navbar-form" role="search">
        <div class="form-group">
          <select id="filter_item" multiple="multiple" name="filter_item[]" data-filter_type="" class="form-control"></select>
        </div>
        <div class="form-group">
          <div class="filter form-control" id="year-filter">
            <input type="hidden" name="filter_year" id="filter_year" value="" />
            Year: 
            <a href="#" class="filter-year" data-value="2015"> 2015 </a>|
            <a href="#" class="filter-year" data-value="2016"> 2016 </a>|
            <a href="#" class="filter-year" data-value="2017"> 2017 </a>|
            <a href="#" class="filter-year" data-value="2018"> 2018 </a>
          </div>
          <div class="filter form-control" id="month-filter">
            <input type="hidden" name="filter_month" id="filter_month" value="" />
            Month: 
            <a href="#" class="filter-month" data-value="Jan"> Jan </a>|
            <a href="#" class="filter-month" data-value="Feb"> Feb </a>|
            <a href="#" class="filter-month" data-value="Mar"> Mar </a>|
            <a href="#" class="filter-month" data-value="Apr"> Apr </a>|
            <a href="#" class="filter-month" data-value="May"> May </a>|
            <a href="#" class="filter-month" data-value="Jun"> Jun </a>|
            <a href="#" class="filter-month" data-value="Jul"> Jul </a>|
            <a href="#" class="filter-month" data-value="Aug"> Aug </a>|
            <a href="#" class="filter-month" data-value="Sep"> Sep </a>| 
            <a href="#" class="filter-month" data-value="Oct"> Oct </a>|
            <a href="#" class="filter-month" data-value="Nov"> Nov </a>|
            <a href="#" class="filter-month" data-value="Dec"> Dec</a>
          </div>
        </div>
        <button id="btn_clear" class="btn btn-danger btn-md"><span class="glyphicon glyphicon-refresh"></span></button>
        <button id="btn_filter" class="btn btn-warning btn-md"><span class="glyphicon glyphicon-filter"></span></button>
      </div>
    </div>
  </div>
</div>        