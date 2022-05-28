function initInput(key) {
	let input = document.getElementById(key);
	
	input.key = key;
	input.onchange = function() {
		localStorage.setItem(this.key, this.value);
	}

	let savedVal = localStorage.getItem(key);
	if (savedVal) {
		input.value = savedVal;
	} else {
		localStorage.setItem(key, input.value);
	}
}

initInput("publisher");
initInput("from");
initInput("to");
initInput("auth_id");


//input parameter --- table number 
// (first, second or third table)
function initTable(tblNum) {

let tbl = document.getElementById("tbl_" + tblNum);
tbl.hidden = true;
let btnShow = document.getElementById("btnShow" + tblNum);
btnShow.tbl = tbl;
btnShow.onclick = function() {
					this.tbl.hidden = false;
		};

let btnHide = document.getElementById("btnHide" + tblNum);
btnHide.tbl = tbl;
btnHide.onclick = function () {
					this.tbl.hidden = true;
}

}

initTable(1);
document.getElementById("btnShow1").addEventListener("click",
		function() {
			let xhr = new XMLHttpRequest();
			let urlStr = "./library.php?publisher=" + localStorage.getItem("publisher");
			xhr.open("GET", urlStr);
			xhr.send(null);
			xhr.onload = () => {
    			if (xhr.status == 200) {
        			let tBody = document.getElementById("tBodyPubl");
        			tBody.innerHTML = xhr.responseText;
        		}
			}
		} 
	);

initTable(2);
document.getElementById("btnShow2").addEventListener("click",
		function() {
			let xhr = new XMLHttpRequest();
			let urlStr = "./library.php?from=" + localStorage.getItem("from")
							+ "&to=" + localStorage.getItem("to");
			xhr.open("GET", urlStr);
			xhr.send(null);
			xhr.onload = () => {
    			if (xhr.status == 200) {
        			let tBody = document.getElementById("tBodyPeriod");
        			tBody.innerHTML = xhr.responseXML.firstChild.innerHTML;
        		}
			}
		} 
	);

initTable(3);
document.getElementById("btnShow3").addEventListener("click",
		function() {
			let xhr = new XMLHttpRequest();
			let urlStr = "./library.php?auth_id=" + localStorage.getItem("auth_id");
			xhr.open("GET", urlStr);
			xhr.send(null);
			xhr.onload = function() {
    			if (this.status == 200) {
        			let books = JSON.parse(this.responseText);
        			
        			let new_tbody = document.createElement('tbody');
    				for (book of books) {
        				let row = new_tbody.insertRow(-1);

        				let k = -1;
        				row.insertCell(++k).innerHTML = book.name;
        				row.insertCell(++k).innerHTML = book.year;
        				row.insertCell(++k).innerHTML = book.quantity;
        				row.insertCell(++k).innerHTML = book.ISBN;
        				row.insertCell(++k).innerHTML = book.resource;
    				}
				    
				    let table = document.getElementById('tblAuth');
    				let old_tbody = table.getElementsByTagName("tbody")[0];
    				old_tbody.parentNode.replaceChild(new_tbody, old_tbody);
        			    
        		}
			}
		} 
	);
