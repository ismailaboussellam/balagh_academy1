import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// الكود الجديد ديال فتح وإغلاق الفورم
document.addEventListener('DOMContentLoaded', () => {
    // فتح الفورم لما تضغط على "رد"
    document.querySelectorAll('.reply-btn').forEach(button => {
        button.addEventListener('click', () => {
            const commentId = button.getAttribute('data-comment-id');
            document.getElementById(`reply-form-${commentId}`).classList.remove('hidden');
        });
    });

    // إغلاق الفورم لما تضغط على "إلغاء"
    document.querySelectorAll('.cancel-reply-btn').forEach(button => {
        button.addEventListener('click', () => {
            const commentId = button.closest('form').id.replace('reply-form-', '');
            document.getElementById(`reply-form-${commentId}`).classList.add('hidden');
        });
    });
});
