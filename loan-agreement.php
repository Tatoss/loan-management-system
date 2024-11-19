<?php include('header.php'); // Include your header if needed ?>
<div class="loan-agreement-container" style="font-size: xx-small;">
    <div align="center">
        Client number : <?php echo $client['FILENR']; ?> --- Loan number : <?php echo $loan['LOANNR']; ?> <br />
        <strong><span style="font-size: x-small !important;">LOAN AGREEMENT</span></strong> <br />
        <strong><?php echo $branch['BRANCH_NAME']; ?></strong> NCR Reg No : <?php echo $branch['NCR_NUMBER']; ?> <br />
        [The Lender] <br />
        <?php echo implode(' ', array($branch['ADDRESS_PHYSICAL1'], $branch['ADDRESS_PHYSICAL2'], $branch['ADDRESS_PHYSICAL3'], $branch['ADDRESS_PHYSICAL4'], $branch['ADDRESS_PHYSICAL5'])); ?> <br />
        Telephone: <?php echo $branch['TEL1']; ?> Fax: <?php echo $branch['FAX']; ?> Email address: <?php echo $branch['EMAIL']; ?>
    </div>

    <!-- Borrower Details Table -->
    <table style="font-size: xx-small; width: 100%;" width="100%">
        <tr>
            <td style="width: 40%;"><strong>SURNAME</strong> [Mr. / Mrs. / Ms.]: <?php echo $client['SURNAME']; ?></td>
            <td style="width: 40%;"><strong>FIRST NAMES</strong> : <?php echo $client['NAME']; ?></td>
            <td style="width: 20%;">[The Borrower]</td>
        </tr>
    </table>

    <!-- Loan Conditions Table -->
    <table style="font-size: xx-small; border-style: solid; border-width: 1; border-collapse: collapse;" width="100%" cellspacing="0" cellpadding="0">
        <tr>
            <td style="width: 20%; border: 1px solid;">1.1 Loan Amount</td>
            <td style="width: 10%; border: 1px solid;">R&nbsp;<?php echo $loan['CAPITAL']; ?></td>
            <td style="width: 20%; border: 1px solid;">1.2 Number of Instalments</td>
            <td style="width: 10%; border: 1px solid;"><?php echo $loan['LOANPERIOD']; ?></td>
            <td style="width: 20%; border: 1px solid;">1.3 Instalment Amount</td>
            <td style="width: 10%; border: 1px solid;">R <?php echo $loan['PAYMENT']; ?></td>
        </tr>
        <!-- Add more rows as needed based on data provided -->
    </table>

    <!-- Cost Elements of Loan -->
    <table style="font-size: xx-small; border: solid 1px; border-collapse: collapse;" width="100%" cellspacing="0" cellpadding="0">
        <tr>
            <td style="width: 80%; border: 1px solid;">2.1 Amount of Interest Charged</td>
            <td style="width: 20%; border: 1px solid;">R <?php echo $loan['INTEREST']; ?></td>
        </tr>
        <tr>
            <td style="width: 80%; border: 1px solid;">2.2 Initiation Fee</td>
            <td style="width: 20%; border: 1px solid;">R <?php echo $loan['INIFEE']; ?></td>
        </tr>
        <!-- Continue with additional rows as specified in the template -->
    </table>

    <!-- Agreement Conditions and Additional Clauses -->
    <div>
        <strong>4. Early Settlement:</strong> The Borrower may settle this agreement at any time in terms of section 125 of the National Credit Act, 34 of 2005.
        <br /><br />
        <strong>5. Proposed Loan Agreement:</strong> This document serves as a proposed loan agreement and quotation.
        <br /><br />
        <!-- Continue with additional clauses as specified -->
    </div>

    <!-- Signature Section -->
    <div align="center">
        <strong>CONDITIONS ACCEPTED BY BORROWER</strong><br />
        Signed at <?php echo $branch['BRANCH_SIGNED_AT']; ?> on <?php echo $loan['TDATE']; ?><br /><br />
        <table style="font-size: xx-small; width: 100%;">
            <tr>
                <td style="width: 50%;"><?php echo $signatures['SIG_BORROWER']; ?></td>
                <td style="width: 50%;"><?php echo $signatures['SIG_WITNESS_1']; ?></td>
            </tr>
            <tr>
                <td style="width: 50%;">_____________________________________</td>
                <td style="width: 50%;">_____________________________________</td>
            </tr>
            <tr>
                <td style="width: 50%;">BORROWER</td>
                <td style="width: 50%;">WITNESS</td>
            </tr>
        </table>

        <!-- Lender Section -->
        <strong>CONDITIONS ACCEPTED BY LENDER</strong><br />
        Signed at <?php echo $branch['BRANCH_SIGNED_AT']; ?> on <?php echo $loan['TDATE']; ?><br /><br />
        <table style="font-size: xx-small; width: 100%;">
            <tr>
                <td style="width: 50%;"><?php echo $signatures['SIG_LENDER']; ?></td>
                <td style="width: 50%;"><?php echo $signatures['SIG_WITNESS_2']; ?></td>
            </tr>
            <tr>
                <td style="width: 50%;">_____________________________________</td>
                <td style="width: 50%;">_____________________________________</td>
            </tr>
            <tr>
                <td style="width: 50%;">LENDER</td>
                <td style="width: 50%;">WITNESS</td>
            </tr>
        </table>
    </div>
</div>

<?php include('footer.php'); // Include your footer if needed ?>
