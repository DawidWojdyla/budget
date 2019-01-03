<div id="tableContainer">
	<section>
		<div class="tableHead">
			Przychody
		</div>
		<table class="balanceTable">
			<?PHP
				if ($chosenIncomes): 
					$incomeCategoryId  = $chosenIncomes[0]->categoryId;
					?>
			<tr style="cursor: pointer;" onclick="showItems('i<?=$incomeCategoryId?>');">
				<td colspan="2"><?=$chosenIncomes[0]->categoryName?></td>
				<td colspan="2" class="text-right"><?=number_format($incomeCategorySum[$chosenIncomes[0]->categoryName], 2,'.',' ')?></td>
			</tr>
					<?PHP
					foreach ($chosenIncomes as $income):
						if($incomeCategoryId != $income->categoryId):
							$incomeCategoryId = $income->categoryId; ?>
			<tr style="cursor: pointer;" onclick="showItems('i<?=$incomeCategoryId?>');">
				<td colspan="2"><?=$income->categoryName?></td>
				<td colspan="2" class="text-right"><?=number_format($incomeCategorySum[$income->categoryName], 2,'.',' ')?></td>
			</tr>
						<?PHP endif; ?>
			
				<tr class="i<?=$income->categoryId?>" id="i<?=$income->incomeId?>s" style="display:none; font-size: 14px; color:grey;" onclick="showEditButtons('i<?=$income->incomeId?>');">
					<td colspan="2" class="text-center pointer"><div id="i<?=$income->incomeId?>comment"><?=$income->comment?></div></td>
					<td class="text-left pointer"><div id="i<?=$income->incomeId?>date"><?=$income->incomeDate?></div></td>
					<td class="text-right pointer"><div id="i<?=$income->incomeId?>amount"><?=number_format($income->amount, 2,'.',' ')?></div></td>
				</tr>
				<tr id="i<?=$income->incomeId?>"></tr>
				
					<?PHP endforeach; ?>
			<tr>
				<td colspan="2">Razem</td><td class="text-right" colspan="2"><?=number_format($allIncomesSum, 2,'.',' ')?></td>
			</tr>
			<?PHP else: ?>
			<div class="text-center option" style="margin:15px;">Nie masz dodanych żadnych przychodów w tym okresie!</div>
			<?PHP endif; ?>
		</table>
	</section>
	<section>
		<div class="tableHead">
			Wydatki
		</div>
		<table class="balanceTable">
			<?PHP
				if ($chosenExpenses): 	
					$expenseCategoryId  = $chosenExpenses[0]->categoryId;
					?>
			<tr style="cursor: pointer;" onclick="showItems('e<?=$expenseCategoryId?>');">
				<td colspan="2"><?=$chosenExpenses[0]->categoryName?></td>
				<td colspan="2" class="text-right"><?=number_format($expenseCategorySum[$chosenExpenses[0]->categoryName], 2,'.',' ')?></td>
			</tr>
					<?PHP
					foreach ($chosenExpenses as $expense):
						if($expenseCategoryId != $expense->categoryId):
							$expenseCategoryId = $expense->categoryId; ?>
			<tr style="cursor: pointer;" onclick="showItems('e<?=$expenseCategoryId?>');">
				<td colspan="2"><?=$expense->categoryName?></td>
				<td colspan="2" class="text-right"><?=number_format($expenseCategorySum[$expense->categoryName], 2,'.',' ')?></td>
			</tr>
						<?PHP endif; ?>
			
				<tr class="e<?=$expense->categoryId?>" id="e<?=$expense->expenseId?>&<?=$expense->paymentMethodId?>s" style="display:none; font-size: 14px; color:grey;" onclick="showEditButtons('e<?=$expense->expenseId?>&<?=$expense->paymentMethodId?>');">
					<td class="text-center pointer"><div id="e<?=$expense->expenseId?>&<?=$expense->paymentMethodId?>comment"><?=$expense->comment?></div></td>
					<td class="text-center pointer"><div id="e<?=$expense->expenseId?>&<?=$expense->paymentMethodId?>paymentMethod"><?=$expense->paymentMethodName?></div></td>
					<td class="text-left pointer"><div id="e<?=$expense->expenseId?>&<?=$expense->paymentMethodId?>date"><?=$expense->expenseDate?></div></td>
					<td class="text-right pointer"><div id="e<?=$expense->expenseId?>&<?=$expense->paymentMethodId?>amount"><?=number_format($expense->amount, 2,'.',' ')?></div></td>
				</tr>
				<tr id="e<?=$expense->expenseId?>&<?=$expense->paymentMethodId?>"></tr>
				
					<?PHP endforeach; ?>
			<tr>
				<td colspan="2">Razem</td><td class="text-right" colspan="2"><?=number_format($allExpensesSum, 2,'.',' ')?></td>
			</tr>
		</table>
		<table class="balanceTable"><div class="text-center"><div id="piechart"></div></div>
			<?PHP else:?>
			<div class="text-center option" style="margin:15px;">Nie masz dodanych żadnych przychodów w tym okresie!</div>
			<?PHP endif; ?>
		</table>
	</section>
	<section>
		<div class="tableHead">
			Bilans
		</div>
		<div class="balanceTable">
			<div class="balance">
					<?PHP $balance = $allIncomesSum - $allExpensesSum; ?>
				<div class="text-center"><?=number_format($balance, 2,'.',' ')?> PLN
					<?PHP if($balance > 0): ?>
					<div class="depiction">Gratulacje. Świetnie zarządzasz finansami!</div>
					<?PHP elseif($balance < 0): ?>
					<div class="depiction">Uważaj, wpadasz w długi!</div>
					<?PHP endif; ?>
				</div>
			</div>
		</div>
	</section>
</div>	