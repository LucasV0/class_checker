function copy() {
	let copyText = document.querySelector("#input");
	copyText.select();
	document.execCommand("copy");
  }
  
  document.querySelector("#copy").addEventListener("click", copy);

