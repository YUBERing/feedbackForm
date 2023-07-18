const URL = 'http://feedback-form:100/api/sendMessage.php';

document.forms.feedbackForm.firstName.onfocus = () => {
  document.querySelector('#nameError').textContent = '';
}

document.forms.feedbackForm.phone.onfocus = () => {
  document.querySelector('#phoneError').textContent = '';
}

document.forms.feedbackForm.email.onfocus = () => {
  document.querySelector('#emailError').textContent = '';
}

document.forms.feedbackForm.message.onfocus = () => {
  document.querySelector('#messageError').textContent = '';
}

document.forms.feedbackForm.onsubmit = async (event) => {
  event.preventDefault();

  const name = this.firstName.value;
  
  const phone = this.phone.value;

  const email = this.email.value;

  const message = this.message.value;

  const {isEmail, answer, errorMessages} = await getMessage(name, email, phone, message);

  this.nameError.textContent = errorMessages.name;
  this.phoneError.textContent = errorMessages.phone;
  this.emailError.textContent = errorMessages.email;
  this.messageError.textContent = errorMessages.message;

  this.answer.textContent = answer;

  if (isEmail) {
    this.submitButton.disabled = isEmail;

    setTimeout(() => {
      this.submitButton.disabled = !isEmail;
      this.answer.textContent = '';
    }, 5000);
  }
}

const getMessage = async (name, email, phone, message) => {
  const response = await axios.post(URL, {name, email, phone, message});

  return response.data;
}