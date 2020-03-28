@php
class Medicine
{
public $prev;
public $next;
public $yearMonth;
private $_thisMonth;
private $_calender_date;

public function __construct()
{

try {
if (isset($_REQUEST['id'])) {
$this->_thisMonth = new \DateTime($_REQUEST['id']);
} elseif (!isset($_GET['t']) || !preg_match('/\A\d{4}-\d{2}\z/', $_GET['t'])) {
throw new \Exception();
} else {
$this->_thisMonth = new \DateTime($_GET['t']);
}
} catch (\Exception $e) {
$this->_thisMonth = new \DateTime('first day of this month');
}

$this->prev = $this->_createPrevLink();
$this->next = $this->_createNextLink();
$this->yearMonth = $this->_thisMonth->format('F Y');
}

private function _createPrevLink()
{
$dt = clone $this->_thisMonth;
return $dt->modify('-1 month')->format('Y-m');
}

private function _createNextLink()
{
$dt = clone $this->_thisMonth;
return $dt->modify('+1 month')->format('Y-m');
}

public function show()
{
$tail = $this->_getTail();
$body = $this->_getBody();
$head = $this->_getHead();
$html = '<tr>' . $tail . $body . $head . '</tr>';
echo $html;
}

private function _getTail()
{
$tail = '';
$lastDayOfPrevMonth = new \DateTime('last day of ' . $this->yearMonth . ' -1 month');
while ($lastDayOfPrevMonth->format('w') < 6) { $tail=sprintf('<td class="gray date">%d</td>',
    $lastDayOfPrevMonth->format('d')) . $tail;
    $lastDayOfPrevMonth->sub(new \DateInterval('P1D'));
    }
    return $tail;
    }

    private function _getBody()
    {
    $body = '';
    $period = new \DatePeriod(
    new \DateTime('first day of ' . $this->yearMonth),
    new \DateInterval('P1D'),
    new \DateTime('first day of ' . $this->yearMonth . ' +1 month')
    );

    $today = new \DateTime('today');
    if (isset($_REQUEST['id'])) {
    $request_date = new \DateTime($_REQUEST['id']);
    }
    foreach ($period as $day) {
    if ($day->format('w') === '0') {
    $body .= "</tr>
    <tr>";
        }

        if (isset($_REQUEST['id'])) {
        $todayClass = '';
        $click_date = ($day->format('Y-n-j') === $request_date->format('Y-n-j')) ? 'click_date': '';
        } else {
        $click_date = '';
        $todayClass = ($day->format('Y-m-d') === $today->format('Y-m-d')) ? 'today' : '';
        }

        $body .= '<td class="youbi_' . $day->format('w') . ' ' . $todayClass . ' ' . $click_date
            . ' date"><a href="check?id=' . $day->format('Y') . '-' . $day->format('m') . '-' .
            $day->format('d') . '" class="link_date">' . $day->format('j') . '</a></td>';
        }
        return $body;
        }

        private function _getHead()
        {
        $head = '';
        $firstDayOfNextMonth = new \DateTime('first day of ' . $this->yearMonth . ' +1 month');
        while ($firstDayOfNextMonth->format('w') > 0) {
        $head .= sprintf('<td class="gray date">%d</td>', $firstDayOfNextMonth->format('d'));
        $firstDayOfNextMonth->add(new \DateInterval('P1D'));
        }
        return $head;
        }
        }

        $medi = new Medicine();
        @endphp
        <table border="0" class="table">
            <thead>
                <tr>
                    <th class="calender_head"><a href="?t={{ $medi->prev }}">&laquo</a>
                    </th>
                    <th colspan="5" class="calender_head">{{ $medi->yearMonth }}</th>
                    <th class="calender_head"><a href="?t={{ $medi->next }}">&raquo</a>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="week sun">Sun</td>
                    <td class="week">Mon</td>
                    <td class="week">Tue</td>
                    <td class="week">Wed</td>
                    <td class="week">Thu</td>
                    <td class="week">Fri</td>
                    <td class="week sat">Sat</td>
                </tr>
                {{ $medi->show() }}
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="7" class="calender_foot"><a href="">Today</a></th>
                </tr>
            </tfoot>
        </table>