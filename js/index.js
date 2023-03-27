function validationData() {
  event.preventDefault();
  const email = document.getElementById("email").value;
  const phone = document.getElementById("phone").value;
  let isValidEmail = true;

  const mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
  if (email.match(mailformat)) {
    isValidEmail = false;
  }

  if (phone === "" || email === "") {
    alert("Please fill all fields...!!!!!!");
    return false;
  } else if (isValidEmail) {
    alert("Invalid Email...!!!!!!");
    return false;
  } else if (phone.length < 10) {
    alert("Invalid Phone...!!!!!!");
    return false;
  } else {
    document.getElementById("loginform").submit();
    return true;
  }
}

function validationCode() {
  event.preventDefault();
  const code = document.getElementById("code").value;

  if (code === "") {
    alert("Please fill the field...!!!!!!");
    return false;
  } else if (code.length != 6) {
    alert("Invalid Code Length...!!!!!!");
    return false;
  } else {
    document.getElementById("codeform").submit();
    return true;
  }
}



