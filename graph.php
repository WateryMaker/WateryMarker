<?php
session_start();
require 'db_connection.php';

$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$user_id = $_SESSION['user_id'];

// ดึงข้อมูลยอดรวมรายเดือน
$sql = "
  SELECT MONTH(date) AS month,
    SUM(CASE WHEN type = 'income' THEN amount ELSE 0 END) AS income,
    SUM(CASE WHEN type = 'expense' THEN amount ELSE 0 END) AS expense
  FROM savings
  WHERE user_id = ?
  GROUP BY MONTH(date)
";
$stmt = $conn->prepare($sql);
$stmt->execute([$user_id]);
$monthly_data = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($monthly_data);

?>
<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>กราฟการเงิน</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link rel="stylesheet" href="dashboard.css">
</head>
<body>
  <h2 style="text-align:center;">กราฟรายรับ - รายจ่ายรายเดือน</h2>
  <canvas id="financeChart" width="800" height="400" style="display:block;margin:auto;"></canvas>

  <script>
    const monthLabels = ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'];
    const chartData = Array(12).fill({income: 0, expense: 0});

    chartDataFromPHP.forEach(entry => {
      const index = parseInt(entry.month) - 1;
      chartData[index] = {
        income: parseFloat(entry.income),
        expense: parseFloat(entry.expense)
      };
    });

    const ctx = document.getElementById('financeChart').getContext('2d');
    new Chart(ctx, {
      type: 'line',
      data: {
        labels: monthLabels,
        datasets: [
          {
            label: 'รายรับ',
            data: chartData.map(e => e.income),
            borderColor: 'green',
            fill: false
          },
          {
            label: 'รายจ่าย',
            data: chartData.map(e => e.expense),
            borderColor: 'red',
            fill: false
          }
        ]
      },
      options: {
        responsive: true,
        plugins: {
          legend: {
            position: 'top'
          },
          title: {
            display: true,
            text: 'สรุปการเงินรายเดือน'
          }
        }
      }
    });
  </script>
</body>
</html>
