<style>
.glass-card {
    background: rgba(255,255,255,0.03);
    backdrop-filter: blur(24px);
    -webkit-backdrop-filter: blur(24px);
    border: 1px solid rgba(255,255,255,0.08);
    border-radius: 28px;
    padding: 40px 32px;
    max-width: 440px;
    width: 100%;
    margin: 0 auto;
}
@media (max-width: 640px) { .glass-card { padding: 28px 20px; border-radius: 22px; } }

.glass-card-inner { }

.animate-fadeIn {
    animation: fadeIn 0.5s ease-out;
}
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(12px); }
    to { opacity: 1; transform: translateY(0); }
}

.input-group {
    position: relative;
    display: flex;
    align-items: center;
}
.input-icon {
    position: absolute;
    left: 14px;
    width: 20px;
    height: 20px;
    color: rgba(255,255,255,0.3);
    pointer-events: none;
    z-index: 1;
}
.input-field {
    width: 100%;
    padding: 14px 14px 14px 44px;
    background: rgba(255,255,255,0.04);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 14px;
    color: #fff;
    font-size: 15px;
    outline: none;
    transition: all 0.2s ease;
}
.input-field::placeholder { color: rgba(255,255,255,0.25); }
.input-field:focus { border-color: #E11D48; background: rgba(255,255,255,0.06); }
.input-field.input-error { border-color: #f87171; background: rgba(248,113,113,0.05); }

.btn-primary {
    background: #E11D48;
    color: #fff;
    border: none;
    border-radius: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}
.btn-primary:hover { background: #BE123C; transform: translateY(-1px); }
.btn-primary:active { transform: scale(0.98); }
</style>
