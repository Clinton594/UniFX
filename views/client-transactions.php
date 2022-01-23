<?php
require_once("includes/client-authentication.php");
$transactions = $generic->getFromTable("transaction", "user_id={$session->user_id}, tx_type!=mining", 0, 30, ID_DESC);
$status_value = $paramControl->load_sources("confirm");
$approval = $paramControl->load_sources("approval");
?>
<!DOCTYPE html>
<html lang="en" class="js">

<head>
	<title>Transactions | <?= $company->name ?></title>
	<?php require_once("includes/client-links.php"); ?>
</head>

<body class="page-user">
	<?php require_once("includes/preloader.php"); ?>
	<div class="topbar-wrap mb-4">
		<?php require_once("includes/client-nav.php"); ?>
	</div>
	<!-- .topbar-wrap -->
	<div class="page-content">
		<div class="container">
			<div class="card content-area">
				<div class="card-innr">
					<div class="card-head">
						<h4 class="card-title">Transactions</h4>
					</div>

					<div class=table-responsive>
						<table class=table>
							<thead>
								<th>S/N</th>
								<th>TX TYPE</th>
								<th>TX REF</th>
								<th>DESCRIPTION</th>
								<th>AMOUNT</th>
								<th>DATE</th>
								<th>STATUS</th>
							</thead>
							<tbody>
								<?php foreach ($transactions as $key => $trans) { ?>
									<tr>
										<td><?= $key + 1 ?></td>
										<td><?= strtoupper($trans->tx_type) ?></td>
										<td><?= $trans->tx_no ?></td>
										<td><?= $trans->description ?></td>
										<td>
											<?php if ($trans->tx_type == "exchange") { ?>
												<?= $fmn->format(round($trans->amount)) . $trans->paid_into ?>
											<?php } else { ?>
												<?= $currency . $fmn->format(round($trans->amount, 2)) ?>
											<?php } ?>
										</td>
										<td>
											<?php $date = new DateTime($trans->date) ?>
											<?= $date->format("jS M, Y") ?>
										</td>
										<td>
											<?php if ($trans->status == 2 || $trans->tx_type == "invoice") { ?>
												<a class="button button-primary mt-0 ml-2 px-2" href="<?= $uri->site ?>payment?hash=<?= $trans->tx_no ?>&_k=<?= $trans->id ?>">Pay</a>
											<?php } else { ?>
												<?= $approval[$trans->status] ?>
											<?php } ?>
										</td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php require_once("includes/client-footer.php"); ?>
</body>

</html>