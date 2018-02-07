var version = "0.0.4";

function mysqlTimeStampToDate(timestamp)
{
  //function parses mysql datetime string and returns javascript Date object
  //input has to be in this format: 2007-06-05 15:26:02
  var regex=/^([0-9]{2,4})-([0-1][0-9])-([0-3][0-9]) (?:([0-2][0-9]):([0-5][0-9]):([0-5][0-9]))?$/;
  var parts=timestamp.replace(regex,"$1 $2 $3 $4 $5 $6").split(' ');
  return new Date(parts[0],parts[1]-1,parts[2],parts[3],parts[4],parts[5]);
}

function getFeedingTimes(all = false)
{
  var sAll = all ? "All" : "";
  $.getJSON('api/v1.php?operation=select' + sAll, function(data)
  {
    var feeding_content = "<table><tr><th>Date</th><th>Time</th><th>Type</th><th>Comment</th></tr>";
    for (i = 0; i < data.length; i++)
    {
      var comment = data[i].comments;
      var date = mysqlTimeStampToDate(data[i].feeding_time);
      var even = i % 2 == 0 ? " class=w3-light-grey" : "";
      var dateTxt = date.toLocaleDateString() + "</td><td><b>"
        + date.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'}) + "</b>";
      feeding_content += "<tr" + even + "><td>" + dateTxt
        + "</td><td class=" + data[i].type_colour + ">" + data[i].type_name
        + "</td><td>" + (comment == undefined ? '' : comment) + "</td></tr>";
    }
    feeding_content += "</table>";
    document.getElementById("feeding_content").innerHTML = feeding_content;
    if (all)
      $("#showAll").toggle();
  });
}

function setFeeding(type)
{
  var comment = prompt("Please enter comment", "");
  if (!comment) {
    alert('Sending cancelled!');
    return;
  }
  $.getJSON('api/v1.php?operation=insert&typeName=' + encodeURI(type)
    + '&comment=' + encodeURI(comment), function(data)
  {
    if (data.rows != 1)
      alert('Something went wrong!')
    else {
      alert(data.type_name + ' added!');
      location.reload();
    }
  });  
}

function getButtons()
{
  $.getJSON('api/v1.php?operation=getTypes', function(data)
  {
    var feeding_content = "";
    for (i = 0; i < data.length; i++)
    {
      feeding_content += "<button onClick='setFeeding(\""
        + data[i].type_name
        + "\")' class=\"" + data[i].type_colour
        + " w3-btn w3-block w3-jumbo w3-wide mybutton\"><b>"
        + data[i].type_name + "</b></button><br />";
    }
    document.getElementById("buttons").innerHTML = feeding_content;
  });
}
