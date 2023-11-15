function magazynowanie()
{
    var rzecz = document.getElementById("rzecz").value;
    var data = document.getElementById("data").value;
    for (var i=0; i<10; i++)
    {
        var i = 
        {
            id:i,
            rzecz:rzecz,
            data:data
        }
    }
    for (var i=0; i<10; i++)
    {
        window.localStorage.setItem(i, JSON.stringify(i))
    }
    for (var i=0; i<10; i++)
    {
        document.write(window.localStorage.getItem(i, JSON.stringify(i)))
    }
}
function lista()
{
    var rzeczy = window.localStorage.getItem('rzecz')
    var element_listy = document.createElement("li")
    var rzecz_listy = document.createTextNode(rzeczy)
    element_listy.appendChild(rzecz_listy)
    var lista = document.getElementById('lista')
    lista.appendChild(element_listy)
}
lista()