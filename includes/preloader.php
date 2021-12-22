<style>
  .rotating {
    -webkit-animation: rotating 2s linear infinite;
    margin-left: 2px
  }

  @-webkit-keyframes rotating {
    from {
      -webkit-transform: rotate(0deg);
    }

    to {
      -webkit-transform: rotate(360deg);
    }
  }
</style>
<div class="preloader">
  <div class="preloader-body">
    <img src=" <?= $company->favicon ?>" class="rotating" alt="" srcset="" width="60px">
  </div>
</div>