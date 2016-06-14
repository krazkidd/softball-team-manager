<?php

  /**************************************************************************

  This file is part of Team Manager.

  Copyright © 2013 Mark Ross <krazkidd@gmail.com>

  Team Manager is free software: you can redistribute it and/or modify
  it under the terms of the GNU Affero General Public License as published by
  the Free Software Foundation, either version 3 of the License, or
  (at your option) any later version.

  Team Manager is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU Affero General Public License for more details.

  You should have received a copy of the GNU Affero General Public License
  along with Team Manager.  If not, see <http://www.gnu.org/licenses/>.

  **************************************************************************/

$title = 'Calendar';

ob_start();

?>
    <h2><?= $leagueDesc ?></h2>

    <h4>Opening day</h4>
    <p><?= $beginDate ?></p>
    <h4>Roster freeze</h4>
    <p>TODO</p>
    <h4>Last game</h4>
    <p>TODO</p>

    <table>
        <tr>
            <th colspan="7"><?= "$monthName $thisYear" ?></th>
        </tr>
        <tr>
            <th>Sun</th>
            <th>Mon</th>
            <th>Tue</th>
            <th>Wed</th>
            <th>Thu</th>
            <th>Fri</th>
            <th>Sat</th>
        </tr>
<?php if ($dayOfWeek != 0): ?>
        <tr>
    <?php for ($i = 0; $i < $dayOfWeek; $i++): ?>
            <td>&nbsp;</td>
    <?php endfor; ?>
<?php endif; ?>

<?php for ($i = 1; $i <= $numDaysInMonth; $i++): ?>
    <?php if ($dayOfWeek == 0): ?>
        <tr>
    <?php endif; ?>
    <?php $dayTime = mktime(23, 59, 59, $thisMonth, $i, $thisYear); ?>
            <td<?= $dayTime < $now ? ' class="calDatePassed"' : '' ?>>
    <?php $gameDay = in_array($i, $gameDays); ?>
    <?php if ($gameDay): ?>
                <a href="<?= $app_dir . '#' ?>">
    <?php endif; ?>
                    <?= $i ?>
    <?php if ($gameDay): ?>
                </a>
    <?php endif; ?>
            </td>
    <?php $dayOfWeek = ($dayOfWeek + 1) % 7; ?>
    <?php if ($dayOfWeek == 0): ?> 
        </tr>
    <?php endif; ?>
<?php endfor; ?>

<?php if ($dayOfWeek != 0): ?>
    <?php for ($i = $dayOfWeek; $i < 7; $i++): ?>
                <td>&nbsp;</td>
    <?php endfor; ?>
        </tr>
<?php endif; ?>
    </table>
<?php

$content = ob_get_clean();

require dirname(__FILE__) . '/../views/begin-view.php';

require dirname(__FILE__) . '/../templates/layout.php';

