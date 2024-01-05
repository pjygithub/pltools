<?php
if (isset($_COOKIE['type'])) {
    setcookie('type', '');
    // setcookie('func', 'ConetionStatusViewer');
}
if (isset($_COOKIE['func'])) {
    setcookie('func', '');
}
if (isset($_COOKIE['show'])) {
    setcookie('show', '');
    // setcookie('func', 'ConetionStatusViewer');
}
if (isset($_COOKIE['machine'])) {
    setcookie('machine', '');
    // setcookie('func', 'ConetionStatusViewer');
}
if (isset($_COOKIE['line'])) {
    setcookie('line', '');
    // setcookie('func', 'ConetionStatusViewer');
}
if (isset($_COOKIE['date_start'])) {
    setcookie('date_start', '');
    // setcookie('func', 'ConetionStatusViewer');
}
if (isset($_COOKIE['date_end'])) {
    setcookie('date_end', '');
    // setcookie('func', 'ConetionStatusViewer');
}
echo "cookie已清理完成！";
// echo "<script>window.location.reload();</script>";
echo "<pre>";
print_r($_COOKIE);
echo "</pre>";
