document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.product-variants .form-group').forEach(group => {
        const label = group.querySelector('label');
        if (!label) return;
        const text = label.textContent.trim();

        for (const [groupId, info] of Object.entries(attributeInfoMap)) {
            if (label && label.textContent.includes(` (${groupId})`)) {
                const icon = document.createElement('span');
                icon.textContent = ' ℹ️';
                icon.style.cursor = 'pointer';
                icon.title = 'Más información';
                icon.onclick = () => alert(info);
                label.appendChild(icon);
            }
        }
    });
});