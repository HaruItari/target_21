<tr>
    <td>
        <?php $user->getLogin(); ?>
    </td>

    <td>
        <?php $user->getDateReg(); ?>
    </td>

    <td>
        <?php $user->getLastOnline(); ?>
    </td>

    <td>
        <?php echo ($user->emailConfirm == 1) ? 'Подтвержден' : 'Не подтвержден'; ?>
    </td>
</tr>