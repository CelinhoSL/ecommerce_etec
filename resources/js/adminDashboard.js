  function logout() {
            if (confirm('Tem certeza que deseja sair do sistema?')) {
                alert('Logout realizado com sucesso!');
                // window.location.href = '/login';
            }
        }
        
        // Animação de entrada dos cards
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.dashboard-card');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    card.style.transition = 'all 0.5s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });