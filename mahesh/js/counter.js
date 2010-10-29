<script type="text/javascript">
var b=0
var y
function startCount1()
{
    document.getElementById('Text1').value=b
    b=b+1
    y=setTimeout("startCount1()",1000);
}

function stopCount1()
{
    clearTimeout(y)
}
</script>