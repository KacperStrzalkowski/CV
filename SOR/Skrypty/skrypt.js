function ukryjInput() {
  let inputDrugaData = document.querySelector("input[name='drugaData']");
  if (inputDrugaData.disabled) {
    inputDrugaData.disabled = false;
  } else {
    inputDrugaData.disabled = true;
  }
}
$(function () {
  $("select").select2();
});
$(".opis").hide();
$(".blokKalendarza").addClass("ukrytyOpis");
$(".data").click(function () {
  $(this).parent(".blokKalendarza").toggleClass("ukrytyOpis", 1000);
  $(this).parent(".blokKalendarza").toggleClass("pokazanyyOpis", 1000);
  $(this).parent(".blokKalendarza").children(".opis").toggle(100);
});
function zmienInputUsun(id) {
  document.querySelector("input[name='idDoUsuniecia']").value = id;
  if (confirm("Czy na pewno chcesz usunąć to zdarzenie?")) {
    document.querySelector(".usuwanie").submit();
  }
}
