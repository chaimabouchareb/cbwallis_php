// js/script.js
document.addEventListener('click', function(e){
  if(e.target.matches('.like-btn') || e.target.closest('.like-btn')){
    const btn = e.target.closest('.like-btn');
    const id = btn.dataset.id;
    fetch('like.php', {
      method: 'POST',
      headers:{'Content-Type':'application/json'},
      body: JSON.stringify({id: id})
    }).then(r=>r.json()).then(json=>{
      if(json.ok){
        btn.querySelector('.count').textContent = json.likes;
      } else {
        if (json.error === 'login') {
          location.href = 'login.php';
        } else if (json.error === 'already') {
          alert('You already liked this');
        } else {
          alert('Error');
        }
      }
    });
  }
});
