export default function showAlert(message) {
  let template = `<div class="ui red message flashMessage"
  style="z-index: 999;
         width: 200px;
        postion: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        position: fixed;
        display: none;">${message}</div>`;
  document.querySelector('body').insertAdjacentHTML('afterbegin', template);
  $('.flashMessage').transition('fade');
  setTimeout(function() {
    $('.flashMessage').transition('fade');
  }, 2000);

  setTimeout(function() {
    $('.flashMessage').remove();
  }, 3000);
}
