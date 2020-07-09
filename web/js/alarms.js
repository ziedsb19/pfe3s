window.onload = function(){
    
    var table_container = document.getElementById("alert_table");
  
    var url = "https://dx-api.thingpark.com/core/latest/api/baseStationAlarms"
    var table_body = document.getElementById("alarm_body");
    var butt_token = document.getElementById('valid_token');
    var alarm_msg = document.getElementById('alarm_msg');

    butt_token.addEventListener('click',function(event){
        event.preventDefault();
        var token = document.getElementById("token_alarm").value.trim();
        alarm_msg.textContent="loading data ...";
       $.ajax({
            url: url,
            headers: { 'Authorization': 'Bearer '+token },
            success : function(data){
                console.log(data);
                if (data.length != 0)
                    alarm_msg.textContent="";
                else
                    alarm_msg.textContent="no data found";

                for (e in data){
                    tr = document.createElement("tr")
                    td = document.createElement("td") 
                    td2 = document.createElement("td") 
                    td3 = document.createElement("td") 
                    td4 = document.createElement("td") 
                    td5 = document.createElement("td") 
                    td6 = document.createElement("td") 
                    td7 = document.createElement("td") 

                    
                    ref = document.createTextNode(data[e]["ref"])
                    occurrence = document.createTextNode(data[e]["occurrence"])
                    lastUpdateTime = document.createTextNode(data[e]["lastUpdateTime"])
                    creationTime = document.createTextNode(data[e]["creationTime"])
                    baseStationAlarmTypeId = document.createTextNode(data[e]["baseStationAlarmTypeId"])
                    alarmState = document.createTextNode(data[e]["alarmState"])
                    acked = document.createTextNode(data[e]["acked"])

                    td.appendChild(ref)
                    td2.appendChild(occurrence)
                    td3.appendChild(lastUpdateTime)
                    td4.appendChild(creationTime)
                    td6.appendChild(alarmState)
                    td5.appendChild(baseStationAlarmTypeId)
                    td7.appendChild(acked)

                    tr.appendChild(td);
                    tr.appendChild(td2);
                    tr.appendChild(td3);
                    tr.appendChild(td4);
                    tr.appendChild(td6);
                    tr.appendChild(td5);
                    tr.appendChild(td7);

                    table_body.appendChild(tr)
                }
            },
        });
    
    })

    
}