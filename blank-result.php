<?PHP
function noResult($data)
{

  if (!$data) {
?>
    <div class="d-flex justify-content-center">
      <img width="350" src="assets/images/no-result.png" alt="">

    </div>
    <p class="d-flex justify-content-center" style="color: #a5a5a5; margin-left: 30px;">Opps! No Record Found.</p>

<?PHP
  }
}

?>