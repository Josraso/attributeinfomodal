document.addEventListener('DOMContentLoaded', function () {
    const icons = document.querySelectorAll('.attribute-info-icon');
    const modal = document.getElementById('attributeInfoModal');
    const modalText = document.getElementById('attributeInfoText');
    const closeBtn = document.querySelector('.attribute-info-modal .close');

    icons.forEach(icon => {
        icon.addEventListener('click', () => {
            modalText.innerText = icon.dataset.text;
            modal.style.display = 'block';
        });
    });

    closeBtn.onclick = function () {
        modal.style.display = 'none';
    };

    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    };
});