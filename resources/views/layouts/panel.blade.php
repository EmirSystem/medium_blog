<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Panel') - BlogPro</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* ===== DESIGN TOKENS ===== */
        :root {
            --sidebar-w: 260px;
            --transition: 0.22s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Admin = indigo/violet, Yazar = cyan/blue */
        body.role-admin {
            --accent:        210 100% 65%;
            --accent-solid:  #6366f1;
            --accent-glow:   rgba(99, 102, 241, 0.35);
            --accent-light:  rgba(99, 102, 241, 0.12);
            --accent-badge:  #818cf8;
            --sidebar-top:   linear-gradient(180deg, #1e1b4b 0%, #0f172a 100%);
            --sidebar-line:  rgba(99,102,241,0.4);
            --header-bar:    linear-gradient(90deg, #6366f1 0%, #a855f7 100%);
        }
        body.role-yazar {
            --accent:        199 100% 60%;
            --accent-solid:  #0ea5e9;
            --accent-glow:   rgba(14, 165, 233, 0.35);
            --accent-light:  rgba(14, 165, 233, 0.12);
            --accent-badge:  #38bdf8;
            --sidebar-top:   linear-gradient(180deg, #0c1a2e 0%, #0f172a 100%);
            --sidebar-line:  rgba(14,165,233,0.4);
            --header-bar:    linear-gradient(90deg, #0ea5e9 0%, #06b6d4 100%);
        }

        /* ===== BASE ===== */
        *, *::before, *::after { box-sizing: border-box; }

        html, body {
            margin: 0; padding: 0;
            height: 100%;
            font-family: 'Inter', system-ui, sans-serif;
            background: #0f172a;
            color: #e2e8f0;
        }

        /* ===== LAYOUT ===== */
        .panel-layout {
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            width: var(--sidebar-w);
            flex-shrink: 0;
            background: var(--sidebar-top);
            border-right: 1px solid rgba(255,255,255,0.06);
            display: flex;
            flex-direction: column;
            position: relative;
            overflow: hidden;
            animation: slideInLeft 0.4s var(--transition) both;
        }

        /* Subtle glow orb in sidebar */
        .sidebar::before {
            content: '';
            position: absolute;
            top: -60px; left: -60px;
            width: 200px; height: 200px;
            border-radius: 50%;
            background: var(--accent-glow);
            filter: blur(60px);
            pointer-events: none;
            animation: pulse-orb 4s ease-in-out infinite alternate;
        }

        /* Top accent bar */
        .sidebar-topbar {
            height: 3px;
            background: var(--header-bar);
            flex-shrink: 0;
        }

        /* Sidebar Logo/Brand */
        .sidebar-brand {
            padding: 20px 20px 16px;
            border-bottom: 1px solid rgba(255,255,255,0.07);
            position: relative;
        }
        .sidebar-brand-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }
        .sidebar-brand-icon {
            width: 36px; height: 36px;
            border-radius: 10px;
            background: var(--header-bar);
            display: flex; align-items: center; justify-content: center;
            font-size: 18px;
            box-shadow: 0 4px 12px var(--accent-glow);
            flex-shrink: 0;
        }
        .sidebar-brand-name {
            font-size: 16px;
            font-weight: 700;
            color: #f1f5f9;
            letter-spacing: -0.3px;
        }
        .sidebar-brand-sub {
            font-size: 11px;
            color: var(--accent-badge);
            font-weight: 500;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            margin-top: 1px;
        }

        /* User card in sidebar */
        .sidebar-user {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 14px 20px;
            margin: 12px 12px 4px;
            border-radius: 12px;
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.06);
            transition: background var(--transition);
        }
        .sidebar-user:hover {
            background: rgba(255,255,255,0.07);
        }
        .sidebar-avatar {
            width: 36px; height: 36px;
            border-radius: 10px;
            background: var(--header-bar);
            display: flex; align-items: center; justify-content: center;
            font-size: 14px;
            font-weight: 700;
            color: #fff;
            flex-shrink: 0;
            box-shadow: 0 2px 8px var(--accent-glow);
        }
        .sidebar-user-name {
            font-size: 13px;
            font-weight: 600;
            color: #f1f5f9;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .sidebar-user-role {
            font-size: 11px;
            color: var(--accent-badge);
            font-weight: 500;
        }

        /* Nav */
        .sidebar-nav {
            flex: 1;
            overflow-y: auto;
            padding: 8px 12px;
            scrollbar-width: thin;
            scrollbar-color: rgba(255,255,255,0.1) transparent;
        }
        .sidebar-nav::-webkit-scrollbar { width: 4px; }
        .sidebar-nav::-webkit-scrollbar-track { background: transparent; }
        .sidebar-nav::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 4px; }

        .nav-section-label {
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: rgba(255,255,255,0.3);
            padding: 12px 12px 6px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 12px;
            border-radius: 9px;
            text-decoration: none;
            font-size: 13.5px;
            font-weight: 500;
            color: rgba(255,255,255,0.65);
            transition: all var(--transition);
            position: relative;
            margin-bottom: 2px;
            overflow: hidden;
        }
        .nav-link::before {
            content: '';
            position: absolute;
            inset: 0;
            background: var(--accent-light);
            opacity: 0;
            transition: opacity var(--transition);
            border-radius: 9px;
        }
        .nav-link:hover {
            color: #fff;
            transform: translateX(3px);
        }
        .nav-link:hover::before { opacity: 1; }

        .nav-link.active {
            color: #fff;
            background: var(--accent-light);
            border: 1px solid var(--sidebar-line);
        }
        .nav-link.active .nav-icon {
            filter: drop-shadow(0 0 6px var(--accent-solid));
        }

        .nav-icon {
            font-size: 16px;
            flex-shrink: 0;
            width: 20px;
            text-align: center;
        }
        .nav-badge {
            margin-left: auto;
            background: var(--header-bar);
            color: #fff;
            font-size: 10px;
            font-weight: 700;
            padding: 2px 7px;
            border-radius: 20px;
            line-height: 1.4;
            animation: badge-pulse 2s ease-in-out infinite;
        }

        /* Sidebar Footer */
        .sidebar-footer {
            padding: 12px;
            border-top: 1px solid rgba(255,255,255,0.07);
        }
        .sidebar-footer .nav-link {
            font-size: 13px;
        }
        .nav-link-danger {
            color: rgba(248, 113, 113, 0.75) !important;
        }
        .nav-link-danger:hover {
            color: #f87171 !important;
            background: rgba(248,113,113,0.1) !important;
        }
        .nav-link-danger:hover::before { opacity: 0 !important; }

        /* ===== MAIN CONTENT ===== */
        .panel-main {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            background: #0f172a;
        }

        /* Top header bar */
        .panel-topbar {
            height: 56px;
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255,255,255,0.06);
            display: flex;
            align-items: center;
            padding: 0 28px;
            flex-shrink: 0;
            gap: 12px;
        }
        .topbar-title {
            font-size: 14px;
            font-weight: 600;
            color: rgba(255,255,255,0.5);
        }
        .topbar-sep { color: rgba(255,255,255,0.2); }
        .topbar-page {
            font-size: 14px;
            font-weight: 600;
            color: #f1f5f9;
        }

        .panel-content {
            flex: 1;
            overflow-y: auto;
            padding: 28px;
            animation: fadeInUp 0.35s var(--transition) both;
            scrollbar-width: thin;
            scrollbar-color: rgba(255,255,255,0.08) transparent;
        }
        .panel-content::-webkit-scrollbar { width: 6px; }
        .panel-content::-webkit-scrollbar-track { background: transparent; }
        .panel-content::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.08); border-radius: 6px; }

        /* ===== SHARED UI COMPONENTS ===== */

        /* Glass card */
        .glass-card {
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 14px;
            backdrop-filter: blur(8px);
            transition: border-color var(--transition), box-shadow var(--transition);
        }
        .glass-card:hover {
            border-color: rgba(255,255,255,0.12);
            box-shadow: 0 4px 24px rgba(0,0,0,0.3);
        }

        /* Stat cards */
        .stat-card {
            border-radius: 16px;
            padding: 22px;
            position: relative;
            overflow: hidden;
            transition: transform var(--transition), box-shadow var(--transition);
            animation: fadeInUp 0.4s var(--transition) both;
        }
        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 32px rgba(0,0,0,0.4);
        }
        .stat-card::after {
            content: '';
            position: absolute;
            right: -20px; top: -20px;
            width: 80px; height: 80px;
            border-radius: 50%;
            background: rgba(255,255,255,0.07);
        }
        .stat-card-1 { background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); animation-delay: 0.05s; }
        .stat-card-2 { background: linear-gradient(135deg, #059669 0%, #0891b2 100%); animation-delay: 0.1s; }
        .stat-card-3 { background: linear-gradient(135deg, #d97706 0%, #dc2626 100%); animation-delay: 0.15s; }
        .stat-card-4 { background: linear-gradient(135deg, #0ea5e9 0%, #8b5cf6 100%); animation-delay: 0.2s; }

        .stat-label {
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.8px;
            text-transform: uppercase;
            color: rgba(255,255,255,0.7);
            margin-bottom: 8px;
        }
        .stat-value {
            font-size: 34px;
            font-weight: 800;
            color: #fff;
            line-height: 1;
            letter-spacing: -1px;
        }
        .stat-icon {
            position: absolute;
            right: 18px; top: 18px;
            font-size: 28px;
            opacity: 0.4;
        }

        /* Page header */
        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
            animation: fadeInUp 0.3s var(--transition) both;
        }
        .page-title {
            font-size: 22px;
            font-weight: 700;
            color: #f1f5f9;
            letter-spacing: -0.5px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .page-title-icon {
            width: 38px; height: 38px;
            border-radius: 10px;
            background: var(--accent-light);
            border: 1px solid var(--sidebar-line);
            display: flex; align-items: center; justify-content: center;
            font-size: 18px;
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 8px 18px;
            border-radius: 9px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            text-decoration: none;
            transition: all var(--transition);
            position: relative;
            overflow: hidden;
        }
        .btn::after {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(255,255,255,0);
            transition: background var(--transition);
        }
        .btn:hover::after { background: rgba(255,255,255,0.1); }
        .btn:active { transform: scale(0.97); }

        .btn-primary {
            background: var(--header-bar);
            color: #fff;
            box-shadow: 0 4px 14px var(--accent-glow);
        }
        .btn-primary:hover {
            box-shadow: 0 6px 20px var(--accent-glow);
            transform: translateY(-1px);
        }
        .btn-success {
            background: linear-gradient(135deg, #059669, #10b981);
            color: #fff;
            box-shadow: 0 4px 12px rgba(16,185,129,0.3);
        }
        .btn-success:hover { box-shadow: 0 6px 18px rgba(16,185,129,0.4); transform: translateY(-1px); }

        .btn-danger {
            background: linear-gradient(135deg, #dc2626, #ef4444);
            color: #fff;
            box-shadow: 0 4px 12px rgba(239,68,68,0.3);
        }
        .btn-danger:hover { box-shadow: 0 6px 18px rgba(239,68,68,0.4); transform: translateY(-1px); }

        .btn-warning {
            background: linear-gradient(135deg, #d97706, #f59e0b);
            color: #fff;
            box-shadow: 0 4px 12px rgba(245,158,11,0.3);
        }
        .btn-warning:hover { box-shadow: 0 6px 18px rgba(245,158,11,0.4); transform: translateY(-1px); }

        .btn-ghost {
            background: rgba(255,255,255,0.06);
            color: rgba(255,255,255,0.7);
            border: 1px solid rgba(255,255,255,0.1);
        }
        .btn-ghost:hover { background: rgba(255,255,255,0.1); color: #fff; }

        .btn-sm { padding: 5px 12px; font-size: 12px; border-radius: 7px; }

        /* Badges */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.2px;
        }
        .badge-success { background: rgba(16,185,129,0.15); color: #34d399; border: 1px solid rgba(16,185,129,0.25); }
        .badge-warning { background: rgba(245,158,11,0.15); color: #fbbf24; border: 1px solid rgba(245,158,11,0.25); }
        .badge-danger  { background: rgba(239,68,68,0.15);  color: #f87171; border: 1px solid rgba(239,68,68,0.25); }
        .badge-info    { background: rgba(99,102,241,0.15); color: #a5b4fc; border: 1px solid rgba(99,102,241,0.25); }
        .badge-gray    { background: rgba(148,163,184,0.1); color: #94a3b8; border: 1px solid rgba(148,163,184,0.15); }
        .badge-purple  { background: rgba(168,85,247,0.15); color: #c084fc; border: 1px solid rgba(168,85,247,0.25); }
        .badge-cyan    { background: rgba(6,182,212,0.15);  color: #22d3ee; border: 1px solid rgba(6,182,212,0.25); }

        /* Alerts */
        .alert {
            padding: 13px 16px;
            border-radius: 10px;
            font-size: 13.5px;
            font-weight: 500;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: slideInDown 0.3s var(--transition) both;
        }
        .alert-success { background: rgba(16,185,129,0.1); border: 1px solid rgba(16,185,129,0.2); color: #6ee7b7; }
        .alert-error   { background: rgba(239,68,68,0.1);  border: 1px solid rgba(239,68,68,0.2);  color: #fca5a5; }
        .alert-info    { background: rgba(14,165,233,0.1); border: 1px solid rgba(14,165,233,0.2); color: #7dd3fc; }
        .alert-warning { background: rgba(245,158,11,0.1); border: 1px solid rgba(245,158,11,0.2); color: #fcd34d; }

        /* Table */
        .panel-table-wrap {
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.07);
            border-radius: 14px;
            overflow: hidden;
            animation: fadeInUp 0.35s var(--transition) 0.1s both;
        }
        .panel-table {
            width: 100%;
            border-collapse: collapse;
        }
        .panel-table thead tr {
            background: rgba(255,255,255,0.04);
            border-bottom: 1px solid rgba(255,255,255,0.07);
        }
        .panel-table th {
            text-align: left;
            padding: 12px 16px;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.8px;
            text-transform: uppercase;
            color: rgba(255,255,255,0.35);
        }
        .panel-table tbody tr {
            border-bottom: 1px solid rgba(255,255,255,0.05);
            transition: background var(--transition);
        }
        .panel-table tbody tr:last-child { border-bottom: none; }
        .panel-table tbody tr:hover { background: rgba(255,255,255,0.04); }
        .panel-table td {
            padding: 12px 16px;
            font-size: 13.5px;
            color: rgba(255,255,255,0.8);
            vertical-align: middle;
        }

        /* User avatar in table */
        .user-avatar-sm {
            width: 32px; height: 32px;
            border-radius: 8px;
            background: var(--header-bar);
            display: flex; align-items: center; justify-content: center;
            font-size: 12px;
            font-weight: 700;
            color: #fff;
            flex-shrink: 0;
        }

        /* Form styles */
        .form-card {
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 16px;
            padding: 28px;
            animation: fadeInUp 0.35s var(--transition) 0.1s both;
        }
        .form-group { margin-bottom: 20px; }
        .form-label {
            display: block;
            font-size: 12.5px;
            font-weight: 600;
            color: rgba(255,255,255,0.6);
            margin-bottom: 7px;
            letter-spacing: 0.3px;
        }
        .form-label span { color: rgba(255,255,255,0.3); font-weight: 400; }
        .form-input, .form-select, .form-textarea {
            width: 100%;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 9px;
            padding: 10px 14px;
            font-size: 13.5px;
            color: #e2e8f0;
            font-family: 'Inter', sans-serif;
            transition: all var(--transition);
            outline: none;
            appearance: none;
        }
        .form-input::placeholder, .form-textarea::placeholder { color: rgba(255,255,255,0.2); }
        .form-input:focus, .form-select:focus, .form-textarea:focus {
            border-color: var(--accent-solid);
            background: rgba(255,255,255,0.07);
            box-shadow: 0 0 0 3px var(--accent-light);
        }
        .form-input.is-error, .form-select.is-error, .form-textarea.is-error {
            border-color: rgba(239,68,68,0.5);
        }
        .form-select option { background: #1e293b; color: #e2e8f0; }
        .form-textarea { resize: vertical; min-height: 120px; line-height: 1.6; }
        .form-error { font-size: 12px; color: #f87171; margin-top: 5px; }

        /* Back link */
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            color: var(--accent-badge);
            text-decoration: none;
            margin-bottom: 16px;
            transition: color var(--transition), gap var(--transition);
            font-weight: 500;
        }
        .back-link:hover { color: #fff; gap: 8px; }

        /* Pending blog card */
        .blog-review-card {
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.07);
            border-radius: 14px;
            overflow: hidden;
            margin-bottom: 14px;
            transition: border-color var(--transition), transform var(--transition);
            animation: fadeInUp 0.35s var(--transition) both;
        }
        .blog-review-card:hover {
            border-color: rgba(255,255,255,0.13);
            transform: translateY(-2px);
        }
        .blog-review-body { padding: 20px; }
        .blog-review-footer {
            padding: 12px 20px;
            background: rgba(255,255,255,0.03);
            border-top: 1px solid rgba(255,255,255,0.06);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Profanity warning */
        .profanity-warning {
            background: rgba(239,68,68,0.08);
            border: 1px solid rgba(239,68,68,0.2);
            border-radius: 9px;
            padding: 10px 14px;
            font-size: 12.5px;
            color: #fca5a5;
            margin-bottom: 12px;
        }

        /* Content preview */
        .content-preview {
            background: rgba(0,0,0,0.2);
            border-radius: 9px;
            padding: 14px;
            font-size: 13px;
            color: rgba(255,255,255,0.55);
            line-height: 1.7;
            border: 1px solid rgba(255,255,255,0.05);
        }

        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 64px 24px;
        }
        .empty-state-icon { font-size: 52px; margin-bottom: 16px; }
        .empty-state-text { font-size: 15px; color: rgba(255,255,255,0.35); margin-bottom: 20px; }

        /* Pagination override */
        .pagination-wrap { margin-top: 20px; }
        .pagination-wrap nav { display: flex; justify-content: flex-end; }
        .pagination-wrap span, .pagination-wrap a {
            display: inline-flex; align-items: center; justify-content: center;
            min-width: 34px; height: 34px;
            padding: 0 10px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 500;
            text-decoration: none;
            color: rgba(255,255,255,0.5);
            border: 1px solid rgba(255,255,255,0.07);
            background: rgba(255,255,255,0.03);
            margin: 0 2px;
            transition: all var(--transition);
        }
        .pagination-wrap a:hover {
            background: var(--accent-light);
            border-color: var(--sidebar-line);
            color: #fff;
        }

        /* ===== ANIMATIONS ===== */
        @keyframes slideInLeft {
            from { transform: translateX(-20px); opacity: 0; }
            to   { transform: translateX(0);     opacity: 1; }
        }
        @keyframes fadeInUp {
            from { transform: translateY(12px); opacity: 0; }
            to   { transform: translateY(0);    opacity: 1; }
        }
        @keyframes slideInDown {
            from { transform: translateY(-8px); opacity: 0; }
            to   { transform: translateY(0);    opacity: 1; }
        }
        @keyframes pulse-orb {
            from { transform: scale(1);    opacity: 0.6; }
            to   { transform: scale(1.15); opacity: 1;   }
        }
        @keyframes badge-pulse {
            0%, 100% { box-shadow: 0 0 0 0 var(--accent-glow); }
            50%       { box-shadow: 0 0 0 5px transparent; }
        }
    </style>
</head>

@php
    $isAdmin = Auth::user()->isSuperAdmin();
    $roleClass = $isAdmin ? 'role-admin' : 'role-yazar';
@endphp

<body class="{{ $roleClass }}">
    <div class="panel-layout">

        <!-- ===== SIDEBAR ===== -->
        <aside class="sidebar">
            <div class="sidebar-topbar"></div>

            <!-- Brand -->
            <div class="sidebar-brand">
                <div class="sidebar-brand-logo">
                    <div class="sidebar-brand-icon">✍️</div>
                    <div>
                        <div class="sidebar-brand-name">BlogPro</div>
                        <div class="sidebar-brand-sub">{{ $isAdmin ? 'Admin Panel' : 'Yazar Panel' }}</div>
                    </div>
                </div>
            </div>

            <!-- User card -->
            <a href="{{ route('profile.edit') }}" class="sidebar-user" style="text-decoration:none;">
                <div class="sidebar-avatar">{{ mb_strtoupper(mb_substr(Auth::user()->name, 0, 1)) }}</div>
                <div style="overflow:hidden; min-width:0;">
                    <div class="sidebar-user-name">{{ Auth::user()->name }}</div>
                    <div class="sidebar-user-role">{{ Auth::user()->role?->name ?? 'Kullanıcı' }}</div>
                </div>
            </a>

            <!-- Navigation -->
            <nav class="sidebar-nav">

                <!-- Dashboard (ortak) -->
                <div class="nav-section-label">Genel</div>
                <a href="{{ route('dashboard') }}"
                   class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <span class="nav-icon">📊</span>
                    Dashboard
                </a>

                @if ($isAdmin)
                    <!-- Admin Menu -->
                    <div class="nav-section-label" style="margin-top:8px;">Blog Yönetimi</div>

                    @php $pendingCount = \App\Models\Blog::where('status','pending')->count(); @endphp
                    <a href="{{ route('admin.blogs.pending') }}"
                       class="nav-link {{ request()->routeIs('admin.blogs.pending') ? 'active' : '' }}">
                        <span class="nav-icon">📋</span>
                        Onay Bekleyenler
                        @if ($pendingCount > 0)
                            <span class="nav-badge">{{ $pendingCount }}</span>
                        @endif
                    </a>

                    <a href="{{ route('admin.blogs.index') }}"
                       class="nav-link {{ request()->routeIs('admin.blogs.index') ? 'active' : '' }}">
                        <span class="nav-icon">📚</span>
                        Tüm Yazılar
                    </a>

                    <div class="nav-section-label" style="margin-top:8px;">Yönetim</div>

                    <a href="{{ route('admin.categories.index') }}"
                       class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                        <span class="nav-icon">📁</span>
                        Kategoriler
                    </a>

                    <a href="{{ route('admin.users.index') }}"
                       class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <span class="nav-icon">👥</span>
                        Kullanıcılar
                    </a>

                @else
                    <!-- Yazar Menu -->
                    <div class="nav-section-label" style="margin-top:8px;">Yazılarım</div>

                    <a href="{{ route('yazar.blogs.index') }}"
                       class="nav-link {{ request()->routeIs('yazar.blogs.index') ? 'active' : '' }}">
                        <span class="nav-icon">📝</span>
                        Yazılarım
                    </a>

                    <a href="{{ route('yazar.blogs.create') }}"
                       class="nav-link {{ request()->routeIs('yazar.blogs.create') ? 'active' : '' }}">
                        <span class="nav-icon">➕</span>
                        Yeni Yazı Yaz
                    </a>
                @endif
            </nav>

            <!-- Footer links -->
            <div class="sidebar-footer">
                <a href="{{ route('profile.edit') }}" class="nav-link">
                    <span class="nav-icon">👤</span>
                    Profilim
                </a>
                <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                    @csrf
                    <button type="submit" class="nav-link nav-link-danger" style="width:100%; background:none; cursor:pointer; font-family:inherit;">
                        <span class="nav-icon">🚪</span>
                        Çıkış Yap
                    </button>
                </form>
            </div>
        </aside>

        <!-- ===== MAIN ===== -->
        <div class="panel-main">

            <!-- Top bar -->
            <div class="panel-topbar">
                <span class="topbar-title">BlogPro</span>
                <span class="topbar-sep">/</span>
                <span class="topbar-page">@yield('title', 'Panel')</span>
            </div>

            <!-- Content -->
            <main class="panel-content">
                @if (session('error'))
                    <div class="alert alert-error">❌ {{ session('error') }}</div>
                @endif
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
