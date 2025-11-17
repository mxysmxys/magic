<?php
// 不要问为什么不用数据库类型的  php的不行吗 简单方便
require_once __DIR__.'/config.php';
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo htmlspecialchars($site_config['site_desc']); ?>">
    <title><?php echo $site_config['site_title']; ?> - <?php echo htmlspecialchars($site_config['site_desc']); ?></title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🌬️</text></svg>">
    <style>
        :root {
            --primary-color: #5CACEE;
            --primary-light: #87CEEB;
            --primary-dark: #2a4e9a;
            --secondary-color: #ff7eb3;
            --accent-color: #5F27CD;
            --success-color: #10AC84;
            --warning-color: #FF9F43;
            --danger-color: #FF6B6B;
            --text-dark: #2a4e9a;
            --text-medium: #5a6b9c;
            --text-light: #7c8db0;
            --bg-gradient-start: #f0f5ff;
            --bg-gradient-end: #e4ecff;
            --card-bg: rgba(255, 255, 255, 0.98);
            --card-text: #333333;
            --box-shadow: 0 8px 25px rgba(70, 110, 180, 0.12);
            --hover-shadow: 0 12px 25px rgba(70, 130, 225, 0.2);
            --transition: all 0.3s ease;
        }
        
        /* 夜间模式变量 */
        .dark-mode {
            --primary-color: #4a89dc;
            --primary-light: #3b76c4;
            --primary-dark: #1a3a70;
            --text-dark: #c8d4e8;
            --text-medium: #a0aec0;
            --text-light: #718096;
            --bg-gradient-start: #0f172a;
            --bg-gradient-end: #1e293b;
            --card-bg: #2d3748;
            --card-text: #e2e8f0;
            --box-shadow: 0 8px 25px rgba(0, 10, 30, 0.3);
            --hover-shadow: 0 12px 25px rgba(0, 15, 40, 0.4);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', 'Microsoft YaHei', sans-serif;
            transition: color 0.4s ease, background-color 0.4s ease, border-color 0.4s ease;
        }
        
        body {
            background: linear-gradient(135deg, var(--bg-gradient-start), var(--bg-gradient-end));
            color: #333;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            position: relative;
            overflow-x: hidden;
            line-height: 1.5;
            padding: 15px;
            transition: background 0.5s ease;
        }
        
        <?php if ($site_config['background_type'] !== 'none'): ?>
        /* 动态背景样式 */
        body {
            background: linear-gradient(135deg, 
                <?php echo $site_config['background_color1']; ?>, 
                <?php echo $site_config['background_color2']; ?>) !important;
            background-attachment: fixed;
        }
        .wave-bg { display: none; }
        <?php endif; ?>

        /* 波浪背景 */
        .wave-bg {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 60px;
            background: url('data:image/svg+xml;utf8,<svg viewBox="0 0 1200 120" xmlns="http://www.w3.org/2000/svg"><path d="M0 0v46.29c47.79 22.2 103.59 32.17 158 28 70.36-5.37 136.33-33.31 206.8-37.5 73.84-4.36 147.54 16.88 218.2 35.26 69.27 18 138.3 24.88 209.4 13.08 36.15-6 69.85-17.84 104.45-29.34C989.49 25 1113-14.29 1200 52.47V0z" fill="rgba(92, 172, 238, 0.1)"/></svg>');
            background-repeat: no-repeat;
            background-size: cover;
            background-position: bottom;
            z-index: -1;
        }
        
        /* 加载动画 */
        .loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: white;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            transition: opacity 0.4s, visibility 0.4s;
        }
        
        .loader-content {
            text-align: center;
            transform: translateY(-30px);
        }
        
        .loader-animation {
            position: relative;
            width: 120px;
            height: 120px;
            margin: 0 auto 30px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        /* 科技感六边形核心 */
        .loader-hexagon {
            position: absolute;
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
            clip-path: polygon(25% 6.7%, 75% 6.7%, 100% 50%, 75% 93.3%, 25% 93.3%, 0% 50%);
            animation: hexRotate 2s linear infinite;
            box-shadow: 0 0 20px rgba(92, 172, 238, 0.5);
        }
        
        /* 外层发光环 */
        .loader-ring {
            position: absolute;
            width: 100px;
            height: 100px;
            border: 2px solid transparent;
            border-radius: 50%;
            border-top: 2px solid var(--primary-color);
            border-right: 2px solid var(--primary-light);
            animation: ringRotate 1.5s linear infinite;
            box-shadow: 0 0 15px rgba(92, 172, 238, 0.3);
        }
        
        /* 内层快速环 */
        .loader-inner-ring {
            position: absolute;
            width: 80px;
            height: 80px;
            border: 1px solid transparent;
            border-radius: 50%;
            border-left: 1px solid var(--accent-color);
            border-bottom: 1px solid var(--primary-light);
            animation: ringRotate 1s linear infinite reverse;
        }
        
        /* 脉冲粒子 */
        .loader-particle {
            position: absolute;
            width: 4px;
            height: 4px;
            background: var(--primary-color);
            border-radius: 50%;
            box-shadow: 0 0 10px var(--primary-color);
            animation: particleOrbit 3s linear infinite;
        }
        
        .loader-particle:nth-child(4) { animation-delay: -0.75s; }
        .loader-particle:nth-child(5) { animation-delay: -1.5s; }
        .loader-particle:nth-child(6) { animation-delay: -2.25s; }
        
        /* 中心脉冲 */
        .loader-pulse {
            position: absolute;
            width: 20px;
            height: 20px;
            background: radial-gradient(circle, var(--primary-color), transparent);
            border-radius: 50%;
            animation: pulse 2s ease-in-out infinite;
        }
        
        .loader-text {
            font-size: 16px;
            color: var(--text-medium);
            letter-spacing: 2px;
            font-weight: 600;
            text-transform: uppercase;
            background: linear-gradient(90deg, var(--primary-color), var(--primary-light), var(--primary-color));
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: textGlow 2s ease-in-out infinite alternate;
        }
        
        /* 动画定义 */
        @keyframes hexRotate {
            0% { transform: rotate(0deg) scale(1); }
            50% { transform: rotate(180deg) scale(1.1); }
            100% { transform: rotate(360deg) scale(1); }
        }
        
        @keyframes ringRotate {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        @keyframes particleOrbit {
            0% {
                transform: rotate(0deg) translateX(50px) scale(1);
                opacity: 1;
            }
            50% {
                transform: rotate(180deg) translateX(50px) scale(0.8);
                opacity: 0.6;
            }
            100% {
                transform: rotate(360deg) translateX(50px) scale(1);
                opacity: 1;
            }
        }
        
        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
                opacity: 0.8;
            }
            50% {
                transform: scale(1.5);
                opacity: 0.3;
            }
        }
        
        @keyframes textGlow {
            0% {
                text-shadow: 0 0 10px rgba(92, 172, 238, 0.5);
            }
            100% {
                text-shadow: 0 0 20px rgba(92, 172, 238, 0.8), 0 0 30px rgba(92, 172, 238, 0.4);
            }
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        .hidden {
            opacity: 0;
            visibility: hidden;
        }
        
        /* 容器样式 */
        .container {
            max-width: 1200px;
            width: 100%;
            margin: 15px auto;
            background: var(--card-bg);
            border-radius: 18px;
            box-shadow: var(--box-shadow);
            padding: 20px;
            position: relative;
            overflow: hidden;
            opacity: 0;
            transform: translateY(10px);
            transition: opacity 0.5s, transform 0.5s, background-color 0.5s ease;
            border: 1px solid rgba(230, 240, 255, 0.8);
            backdrop-filter: blur(4px);
        }
        
        .dark-mode .container {
            border-color: rgba(50, 65, 90, 0.9);
        }
        
        /* 日夜切换按钮 */
        .theme-toggle {
            position: absolute;
            top: 20px;
            right: 20px;
            width: 60px;
            height: 30px;
            background: linear-gradient(135deg, var(--primary-light), var(--primary-color));
            border-radius: 30px;
            cursor: pointer;
            display: flex;
            align-items: center;
            padding: 0 5px;
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            z-index: 10;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        
        .dark-mode .theme-toggle {
            background: linear-gradient(135deg, #2c3e50, #34495e);
        }
        
        .toggle-circle {
            width: 22px;
            height: 22px;
            background: white;
            border-radius: 50%;
            transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            position: relative;
            z-index: 2;
        }
        
        .theme-toggle.active .toggle-circle {
            transform: translateX(30px);
        }
        
        .sun, .moon {
            position: absolute;
            transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
            opacity: 0;
            transform-origin: center;
        }
        
        .sun {
            left: 8px;
            color: #FFD700;
            transform: scale(0.5) rotate(-30deg);
        }
        
        .moon {
            right: 8px;
            color: #f1c40f;
            transform: scale(0.5) rotate(30deg);
        }
        
        .theme-toggle:not(.active) .sun {
            opacity: 1;
            transform: scale(0.7) rotate(0);
            animation: sun-shine 2s ease-out forwards;
        }
        
        .theme-toggle.active .moon {
            opacity: 1;
            transform: scale(0.7) rotate(0);
            animation: moon-glow 2s ease-out forwards;
        }
        
        @keyframes sun-shine {
            0% { transform: scale(0.5) rotate(-30deg); opacity: 0; }
            50% { transform: scale(0.8) rotate(10deg); opacity: 1; }
            100% { transform: scale(0.7) rotate(0); opacity: 1; }
        }
        
        @keyframes moon-glow {
            0% { transform: scale(0.5) rotate(30deg); opacity: 0; }
            50% { transform: scale(0.8) rotate(-10deg); opacity: 1; }
            100% { transform: scale(0.7) rotate(0); opacity: 1; }
        }
        
        /* 背景装饰 */
        .bg-element {
            position: absolute;
            border-radius: 50%;
            opacity: 0.08;
            z-index: -1;
            filter: blur(8px);
            transition: background 0.5s ease;
        }
        
        .bg-1 {
            width: 180px;
            height: 180px;
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            top: -50px;
            right: -50px;
        }
        
        .bg-2 {
            width: 140px;
            height: 140px;
            background: linear-gradient(135deg, var(--primary-light), var(--success-color));
            bottom: -40px;
            left: -30px;
        }
        
        .bg-3 {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, var(--danger-color), var(--warning-color));
            bottom: 80px;
            right: 70px;
        }
        
        /* 顶部区域 */
        header {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 0 0 20px;
            margin-bottom: 15px;
            position: relative;
        }
        
        .avatar-container {
            position: relative;
            width: 96px;
            height: 96px;
            margin-bottom: 16px;
            margin-top: 5px;
        }
        
        .avatar {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            overflow: hidden;
            border: 3px solid rgba(255, 255, 255, 0.95);
            box-shadow: 0 6px 16px rgba(40, 90, 150, 0.15);
            background: #f0f7ff;
            position: relative;
            z-index: 2;
            transition: transform 0.4s ease;
        }
        
        .avatar:hover {
            transform: scale(1.05);
        }
        
        .avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }
        
        .avatar-bg {
            position: absolute;
            top: -10px;
            left: -10px;
            width: 116px;
            height: 116px;
            border-radius: 50%;
            background: rgba(92, 172, 238, 0.1);
            z-index: 1;
            animation: pulse 2s infinite;
        }
        
        .nickname {
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 8px;
            color: var(--primary-dark);
            text-align: center;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            transition: color 0.4s ease;
        }
        
        .dark-mode .nickname {
            color: white;
        }
        
        .user-desc {
            opacity: 0.9;
            font-size: 14px;
            color: var(--text-medium);
            font-style: italic;
            text-align: center;
            max-width: 320px;
            margin-bottom: 16px;
            padding: 0 10px;
            transition: color 0.4s ease;
            line-height: 1.6;
        }
        
        .time-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 10px;
            text-align: center;
        }
        
        .logo {
            font-size: 30px;
            margin-bottom: 4px;
            color: var(--primary-color);
            font-weight: 700;
            letter-spacing: 1px;
            transition: color 0.4s ease;
            position: relative;
        }
        
        /* 像素风格时间显示 - 清晰版本 */
        #time {
            font-family: 'Courier New', monospace;
            font-size: 52px;
            font-weight: 900;
            letter-spacing: 6px;
            color: #0099ff;
            text-shadow: 
                1px 1px 0px #0066cc,
                2px 2px 0px #004499,
                0 0 15px rgba(0, 153, 255, 0.6);
            position: relative;
            display: inline-block;
            transition: all 0.3s ease;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        
        /* 夜间模式下的像素时间 */
        .dark-mode #time {
            color: #ff4466;
            text-shadow: 
                1px 1px 0px #cc2244,
                2px 2px 0px #aa1133,
                0 0 20px rgba(255, 68, 102, 0.8);
        }
        
        /* 像素闪烁效果 */
        @keyframes pixelGlow {
            0%, 100% { 
                text-shadow: 
                    1px 1px 0px #0066cc,
                    2px 2px 0px #004499,
                    0 0 15px rgba(0, 153, 255, 0.6);
            }
            50% { 
                text-shadow: 
                    1px 1px 0px #0066cc,
                    2px 2px 0px #004499,
                    0 0 25px rgba(0, 153, 255, 0.9);
            }
        }
        
        @keyframes pixelGlowDark {
            0%, 100% { 
                text-shadow: 
                    1px 1px 0px #cc2244,
                    2px 2px 0px #aa1133,
                    0 0 20px rgba(255, 68, 102, 0.8);
            }
            50% { 
                text-shadow: 
                    1px 1px 0px #cc2244,
                    2px 2px 0px #aa1133,
                    0 0 30px rgba(255, 68, 102, 1);
            }
        }
        
        #time:hover {
            animation: pixelGlow 1.5s ease-in-out infinite;
        }
        
        .dark-mode #time:hover {
            animation: pixelGlowDark 1.5s ease-in-out infinite;
        }
        
        .dark-mode .logo {
            color: white;
        }
        
        #date {
            font-size: 14px;
            color: var(--text-medium);
            font-weight: 500;
            transition: color 0.4s ease;
        }
        
        .weather {
            font-size: 13px;
            color: var(--text-medium);
            margin-top: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 4px;
            transition: color 0.4s ease;
        }
        
        /* 分隔装饰线 */
        .divider {
            height: 1px;
            background: linear-gradient(to right, transparent, rgba(100, 150, 255, 0.3), transparent);
            margin: 0 auto 20px;
            width: 80%;
            position: relative;
        }
        
        .divider-dots {
            position: absolute;
            top: -4px;
            left: 0;
            width: 100%;
            display: flex;
            justify-content: space-evenly;
            pointer-events: none;
        }
        
        .divider-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #FFD700;
            box-shadow: 0 0 5px rgba(255, 215, 0, 0.6);
        }
        
        /* 网站导航区 */
        .app-section {
            margin-bottom: 25px;
        }
        
        .app-section h2 {
            margin: 0 0 20px;
            font-weight: 600;
            text-align: center;
            color: var(--primary-dark);
            font-size: 20px;
            position: relative;
            padding-bottom: 8px;
            transition: color 0.4s ease;
        }
        
        .dark-mode .app-section h2 {
            color: white;
        }
        
        .app-section h2::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background: linear-gradient(to right, var(--primary-light), var(--primary-color));
            border-radius: 3px;
            transition: background 0.4s ease;
        }
        
        .app-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
            gap: 18px;
            margin-bottom: 15px;
            opacity: 0;
            transform: translateY(10px);
            transition: opacity 0.6s 0.2s, transform 0.6s 0.2s;
            justify-items: center;
        }
        
        /* 正方形卡片 - 调整为只显示图标 */
        .app-item {
            width: 100px;
            display: flex;
            flex-direction: column;
            align-items: center;
            transition: var(--transition);
            cursor: pointer;
            position: relative;
        }
        
        .app-card {
            width: 100px;
            height: 100px;
            background: var(--card-bg);
            border-radius: 16px;
            padding: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: var(--box-shadow);
            border: 1px solid rgba(230, 240, 255, 0.9);
            position: relative;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            margin-bottom: 8px;
        }
        
        .dark-mode .app-card {
            border-color: rgba(50, 65, 90, 0.9);
        }
        
        .app-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(255,255,255,0.1), rgba(92, 172, 238, 0.05));
            z-index: 0;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .app-item:hover .app-card {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(92, 172, 238, 0.2);
        }
        
        .app-item:hover .app-card::before {
            opacity: 1;
        }
        
        .app-item:active .app-card {
            transform: translateY(-1px) scale(0.98);
            transition: all 0.1s ease;
        }
        
        .app-item:focus,
        .app-item:focus-visible {
            outline: none;
            box-shadow: none;
        }
        
        .app-item {
            -webkit-tap-highlight-color: transparent;
            outline: none;
            border: none;
        }
        
        /* 优化图标尺寸，让图标填满整个卡片 */
        .app-icon {
            width: 84px;
            height: 84px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1;
            transition: all 0.3s ease;
        }
        
        .app-icon img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            border-radius: 14px;
            transition: all 0.3s ease;
        }
        
        .app-icon svg {
            width: 70px !important;
            height: 70px !important;
            max-width: 70px;
            max-height: 70px;
            transition: all 0.3s ease;
            display: block;
        }
        
        .app-icon img {
            width: 100% !important;
            height: 100% !important;
            object-fit: contain;
            max-width: 84px;
            max-height: 84px;
        }
        
        /* 卡片名字样式 - 显示在卡片下方 */
        .app-name {
            font-size: 13px;
            color: var(--card-text);
            font-weight: 600;
            margin-top: 4px;
            transition: color 0.3s;
            text-align: center;
            line-height: 1.3;
            max-width: 100px;
            word-wrap: break-word;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        
        .app-item:hover .app-name {
            color: var(--primary-color);
        }
        
        /* 页脚哦 */
        footer {
            text-align: center;
            padding: 16px 0 8px;
            color: var(--text-medium);
            font-size: 12px;
            margin-top: 15px;
            opacity: 0;
            transition: opacity 0.5s 0.4s, color 0.4s ease;
            position: relative;
            z-index: 1;
            line-height: 1.6;
        }
        
        footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80%;
            height: 1px;
            background: linear-gradient(to right, transparent, rgba(120, 160, 240, 0.2), transparent);
            transition: background 0.4s ease;
        }
        
        .copyright {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            margin-bottom: 5px;
        }
        
        .copyright svg {
            width: 12px;
            height: 12px;
            transition: fill 0.4s ease;
        }
        
        .visitor-count {
            font-size: 11px;
            margin-top: 5px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }
        
        .footer-links {
            display: flex;
            justify-content: center;
            gap: 18px;
            margin-top: 12px;
            font-size: 12px;
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 25px;
            padding: 12px 20px;
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            max-width: fit-content;
            margin-left: auto;
            margin-right: auto;
        }
        
        .footer-links a {
            color: var(--primary-color);
            text-decoration: none;
            transition: all 0.3s ease;
            padding: 6px 12px;
            border-radius: 15px;
            position: relative;
        }
        
        .footer-links a:hover {
            color: var(--accent-color);
            background: rgba(92, 172, 238, 0.1);
            transform: translateY(-1px);
        }
        
        /* 夜间模式下的底部链接 */
        .dark-mode .footer-links {
            background: rgba(45, 55, 72, 0.9);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 4px 15px rgba(0, 10, 30, 0.3);
        }
        
        .dark-mode .footer-links a {
            color: #ffffff;
        }
        
        .dark-mode .footer-links a:hover {
            color: var(--primary-light);
            background: rgba(255, 255, 255, 0.1);
        }
        
        /* 公告弹窗样式- */
        .announcement-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9998;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.4s, visibility 0.4s;
            backdrop-filter: blur(4px);
        }
        
        .announcement-modal.active {
            opacity: 1;
            visibility: visible;
        }
        
        .announcement-content {
            background: var(--card-bg);
            border-radius: 16px;
            box-shadow: var(--box-shadow);
            max-width: 460px;
            width: 90%;
            overflow: hidden;
            position: relative;
            transform: scale(0.9);
            transition: transform 0.4s ease, opacity 0.4s ease, background-color 0.4s ease;
            opacity: 0;
        }
        
        .announcement-modal.active .announcement-content {
            transform: scale(1);
            opacity: 1;
        }
        
        .announcement-header {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: white;
            padding: 18px 22px;
            text-align: center;
            position: relative;
            transition: background 0.4s ease;
        }
        
        .announcement-header h3 {
            font-size: 18px;
            font-weight: 700;
            margin: 0;
        }
        
        .announcement-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s;
        }
        
        .announcement-badge:hover {
            background: rgba(255, 255, 255, 0.3);
        }
        
        .announcement-body {
            padding: 20px;
        }
        
        .announcement-body p {
            color: var(--card-text);
            line-height: 1.6;
            margin-bottom: 14px;
            font-size: 14px;
            position: relative;
            padding-left: 20px;
            transition: color 0.4s ease;
        }
        
        .announcement-body p:before {
            content: '•';
            position: absolute;
            left: 0;
            top: 0;
            color: var(--primary-color);
            font-size: 20px;
            transition: color 0.4s ease;
        }
        
        .announcement-footer {
            padding: 16px 22px;
            background: #f8faff;
            text-align: center;
            border-top: 1px solid rgba(230, 240, 255, 0.9);
            transition: all 0.4s ease;
        }
        
        .dark-mode .announcement-footer {
            background: #1a202c;
            border-top-color: rgba(50, 65, 90, 0.9);
        }
        
        .close-btn {
            background: linear-gradient(135deg, var(--primary-light), var(--primary-color));
            color: white;
            border: none;
            padding: 10px 22px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            box-shadow: 0 4px 12px rgba(92, 172, 238, 0.25);
        }
        
        .close-btn:hover {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            box-shadow: 0 6px 16px rgba(92, 172, 238, 0.3);
            transform: translateY(-2px);
        }
        
        /* 小动画 */
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-6px); }
            100% { transform: translateY(0px); }
        }
        
        .floating {
            animation: float 4s ease-in-out infinite;
        }
        
        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(92, 172, 238, 0.4); }
            70% { box-shadow: 0 0 0 10px rgba(92, 172, 238, 0); }
            100% { box-shadow: 0 0 0 0 rgba(92, 172, 238, 0); }
        }
        
        /* 天气图标动画 */
        @keyframes sun-shine {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        @keyframes cloud-float {
            0% { transform: translateX(0); }
            50% { transform: translateX(5px); }
            100% { transform: translateX(0); }
        }
        
        @keyframes rain-fall {
            0% { transform: translateY(-5px); opacity: 0; }
            50% { opacity: 1; }
            100% { transform: translateY(5px); opacity: 0; }
        }
        
        .weather-icon {
            display: inline-block;
            transition: all 0.5s ease;
        }
        
        .sun-icon {
            animation: sun-shine 15s linear infinite;
        }
        
        .cloud-icon {
            animation: cloud-float 8s ease-in-out infinite;
        }
        
        .rain-icon {
            position: relative;
        }
        
        .rain-icon::after {
            content: "💧💧💧";
            position: absolute;
            top: 15px;
            left: -5px;
            font-size: 8px;
            animation: rain-fall 1s linear infinite;
        }
        
        /* 响应式设计 */
        @media (max-width: 768px) {
            .wave-bg {
                height: 50px;
            }
            
            .container {
                padding: 18px;
                margin-top: 10px;
            }
            
            .avatar-container {
                width: 90px;
                height: 90px;
            }
            
            .avatar-bg {
                width: 110px;
                height: 110px;
            }
            
            .nickname {
                font-size: 20px;
            }
            
            .logo {
                font-size: 28px;
            }
            
            /* 移动端像素时间调整 */
            #time {
                font-size: 40px;
                letter-spacing: 5px;
            }
            
            .app-grid {
                grid-template-columns: repeat(auto-fill, minmax(85px, 1fr));
                gap: 12px;
            }
            
            .app-item {
                width: 85px;
            }
            
            .app-card {
                width: 85px;
                height: 85px;
                padding: 6px;
            }
            
            .app-icon {
                width: 73px;
                height: 73px;
            }
            
            .app-icon svg {
                width: 55px;
                height: 55px;
            }
            
            .app-name {
                font-size: 12px;
                max-width: 85px;
                margin-top: 2px;
            }
            
            .footer-links {
                gap: 12px;
                padding: 10px 16px;
                font-size: 11px;
            }
            
            .footer-links a {
                padding: 4px 8px;
            }
        }
        
        @media (max-width: 480px) {
            body {
                padding: 12px;
            }
            
            .wave-bg {
                height: 40px;
            }
            
            .container {
                padding: 16px;
                padding-left: 12px; /* 稍微减小内边距 */
                padding-right: 12px;
            }
            
            .avatar-container {
                width: 80px;
                height: 80px;
                margin-bottom: 14px;
            }
            
            .avatar-bg {
                width: 100px;
                height: 100px;
            }
            
            .nickname {
                font-size: 19px;
            }
            
            .user-desc {
                font-size: 13px;
            }
            
            .logo {
                font-size: 26px;
            }
            
            #date {
                font-size: 13px;
            }
            
            .app-grid {
                gap: 8px; /* 进一步减小小屏幕间距 */
            }
            
            .app-card {
                padding: 5px;
                border-radius: 12px;
            }
            
            .app-icon {
                width: 65px;
                height: 65px;
            }
            
            .app-icon svg {
                width: 50px;
                height: 50px;
            }
            
            .app-name {
                font-size: 11px;
                margin-top: 2px;
            }
            
            /* 小屏幕像素时间 */
            #time {
                font-size: 32px;
                letter-spacing: 4px;
            }
            
            .footer-links {
                gap: 10px;
                font-size: 10px;
                padding: 8px 12px;
            }
            
            .footer-links a {
                padding: 3px 6px;
            }
        }
        
        @media (max-width: 350px) {
            .app-grid {
                grid-template-columns: repeat(auto-fill, minmax(75px, 1fr));
                gap: 8px;
            }
            
            .app-item {
                width: 75px;
            }
            
            .app-card {
                width: 75px;
                height: 75px;
                padding: 4px;
            }
            
            .app-icon {
                width: 67px;
                height: 67px;
            }
            
            .app-icon svg {
                width: 50px;
                height: 50px;
            }
            
            /* 超小屏幕像素时间 */
            #time {
                font-size: 28px;
                letter-spacing: 3px;
            }
            
            .avatar-container {
                width: 70px;
                height: 70px;
            }
            
            .avatar-bg {
                width: 90px;
                height: 90px;
            }
            
            .nickname {
                font-size: 18px;
            }
            
            .logo {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <!-- 波浪背景 -->
    <div class="wave-bg"></div>
    
    <!-- 加载动画 -->
    <div class="loader" id="loader">
        <div class="loader-content">
            <div class="loader-animation">
                <!-- 中心六边形核心 -->
                <div class="loader-hexagon"></div>
                
                <!-- 中心脉冲 -->
                <div class="loader-pulse"></div>
                
                <!-- 轨道粒子 -->
                <div class="loader-particle"></div>
                <div class="loader-particle"></div>
                <div class="loader-particle"></div>
                
                <!-- 内层快速环 -->
                <div class="loader-inner-ring"></div>
                
                <!-- 外层发光环 -->
                <div class="loader-ring"></div>
            </div>
                            <div class="loader-text"><?php echo htmlspecialchars($site_config['loading_text']); ?></div>
        </div>
    </div>
    
    <div class="container" id="container">
        <!-- 日夜切换按钮 -->
        <div class="theme-toggle" id="themeToggle">
            <div class="toggle-circle"></div>
            <div class="sun">☀️</div>
            <div class="moon">🌙</div>
        </div>
        
        <!-- 背景装饰 -->
        <div class="bg-element bg-1 floating"></div>
        <div class="bg-element bg-2 floating"></div>
        <div class="bg-element bg-3 floating"></div>
        
        <!-- 顶部区域 -->
        <header>
            <div style="display: flex; flex-direction: column; align-items: center; width: 100%;">
                <div class="avatar-container">
                    <div class="avatar">
                        <img src="<?php echo $site_config['avatar_url']; ?>" alt="听风头像">
                    </div>
                    <div class="avatar-bg"></div>
                </div>
                <div class="user-info">
                    <h3 class="nickname"><?php echo $site_config['site_title']; ?></h3>
                    <p class="user-desc" id="netEaseComment">加载中...</p>
                </div>
            </div>
            <div class="time-container">
                <h1 class="logo"><span id="time">00:00</span></h1>
                <p id="date">正在加载日期...</p>
                <div class="weather" id="weather">
                    <span class="weather-status">天气：晴</span>
                    <span class="weather-icon sun-icon">☀️</span>
                    <span class="weather-temp">25℃</span>
                </div>
            </div>
        </header>
        
        <!-- 分隔装饰线 -->
        <div class="divider">
            <div class="divider-dots">
                <div class="divider-dot"></div>
                <div class="divider-dot"></div>
                <div class="divider-dot"></div>
                <div class="divider-dot"></div>
            </div>
        </div>

        <!-- 网站导航 -->
        <div class="app-section">
            <h2>快捷导航</h2>
            <div class="app-grid">
                <?php foreach ($site_config['apps'] as $app): ?>
                <div class="app-item" data-app-name="<?php echo $app['name']; ?>">
                    <div class="app-card">
                        <div class="app-icon" style="background:<?php echo $app['icon_bg']; ?>">
                            <?php echo $app['icon_svg']; ?>
                        </div>
                    </div>
                    <div class="app-name"><?php echo $app['name']; ?></div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- 底部信息 -->
        <footer>
            <div class="copyright">
                <svg width="14" height="14" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm-2-11.5c0-.83.67-1.5 1.5-1.5s1.5.67 1.5 1.5-.67 1.5-1.5 1.5-1.5-.67-1.5-1.5zm7 6c0 .28-.22.5-.5.5h-7c-.28 0-.5-.22-.5-.5v-1c0-.28.22-.5.5-.5h7c.28 0 .5.22.5.5v1z"/>
                </svg>
                <span><?php echo $site_config['copyright']; ?></span>
            </div>
            
            <div class="visitor-count">
                <svg width="12" height="12" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                </svg>
                <span>今日访问量: <span id="visitorCount">19876</span> 次</span>
            </div>
            
            <div class="footer-links">
                <?php foreach ($site_config['footer_links'] as $link): ?>
                <a href="<?php echo $link['url']; ?>"><?php echo $link['text']; ?></a>
                <?php endforeach; ?>
            </div>
        </footer>
    </div>
    
    <!-- 公告弹窗 -->
    <div class="announcement-modal" id="announcementModal">
        <div class="announcement-content">
            <div class="announcement-header">
                <h3>重要公告</h3>
                <div class="announcement-badge" id="closeAnnouncement">×</div>
            </div>
            <div class="announcement-body">
                <p>导航页面已完成全面优化！</p>
                <p>应用图标已重新设计，视觉效果提升</p>
                <p>「免费去插播」服务持续优化中</p>
                <p>瓜子采集+解析稳定速度快推荐购买！</p>
            </div>
            <div class="announcement-footer">
                <button class="close-btn" id="closeAnnouncementBtn">我知道了</button>
            </div>
        </div>
    </div>

    <script>
        // 动态背景初始化（仅在非"none"时执行0.0）
        <?php if ($site_config['background_type'] !== 'none'): ?>
        document.addEventListener('DOMContentLoaded', function() {
            const bgType = '<?php echo $site_config["background_type"]; ?>';
            
            if (bgType === 'particles') initParticles();
            else if (bgType === 'waves') initWaves();
            else if (bgType === 'stars') initStars();
            else if (bgType === 'circles') initCircles();
            else if (bgType === 'matrix') initMatrix();
            else if (bgType === 'bubbles') initBubbles();
            else if (bgType === 'fireflies') initFireflies();
        });

        // 粒子效果
        function initParticles() {
            const canvas = document.createElement('canvas');
            canvas.style.position = 'fixed';
            canvas.style.top = '0';
            canvas.style.left = '0';
            canvas.style.zIndex = '-1';
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
            document.body.appendChild(canvas);

            const ctx = canvas.getContext('2d');
            const particles = [];
            const particleCount = window.innerWidth < 768 ? 30 : 50;

            for (let i = 0; i < particleCount; i++) {
                particles.push({
                    x: Math.random() * canvas.width,
                    y: Math.random() * canvas.height,
                    size: Math.random() * 3 + 1,
                    speedX: Math.random() * 1 - 0.5,
                    speedY: Math.random() * 1 - 0.5
                });
            }

            function animate() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                ctx.fillStyle = 'rgba(255, 255, 255, 0.5)';

                particles.forEach(p => {
                    ctx.beginPath();
                    ctx.arc(p.x, p.y, p.size, 0, Math.PI * 2);
                    ctx.fill();

                    p.x += p.speedX;
                    p.y += p.speedY;

                    if (p.x < 0 || p.x > canvas.width) p.speedX *= -1;
                    if (p.y < 0 || p.y > canvas.height) p.speedY *= -1;
                });

                requestAnimationFrame(animate);
            }

            animate();

            window.addEventListener('resize', function() {
                canvas.width = window.innerWidth;
                canvas.height = window.innerHeight;
            });
        }

        // 波浪效果
        function initWaves() {
            const canvas = document.createElement('canvas');
            canvas.style.position = 'fixed';
            canvas.style.top = '0';
            canvas.style.left = '0';
            canvas.style.zIndex = '-1';
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
            document.body.appendChild(canvas);

            const ctx = canvas.getContext('2d');
            let time = 0;

            function animate() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                ctx.fillStyle = 'rgba(255, 255, 255, 0.1)';
                ctx.beginPath();

                for (let x = 0; x < canvas.width; x++) {
                    const y = Math.sin(x * 0.01 + time) * 15 + canvas.height / 2;
                    if (x === 0) ctx.moveTo(x, y);
                    else ctx.lineTo(x, y);
                }

                ctx.lineTo(canvas.width, canvas.height);
                ctx.lineTo(0, canvas.height);
                ctx.closePath();
                ctx.fill();

                time += 0.05;
                requestAnimationFrame(animate);
            }

            animate();

            window.addEventListener('resize', function() {
                canvas.width = window.innerWidth;
                canvas.height = window.innerHeight;
            });
        }

        // 星空效果
        function initStars() {
            const canvas = document.createElement('canvas');
            canvas.style.position = 'fixed';
            canvas.style.top = '0';
            canvas.style.left = '0';
            canvas.style.zIndex = '-1';
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
            document.body.appendChild(canvas);

            const ctx = canvas.getContext('2d');
            const stars = [];
            const starCount = window.innerWidth < 768 ? 60 : 100;

            for (let i = 0; i < starCount; i++) {
                stars.push({
                    x: Math.random() * canvas.width,
                    y: Math.random() * canvas.height,
                    size: Math.random() * 2 + 0.5,
                    alpha: Math.random() * 0.8 + 0.2
                });
            }

            function animate() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);

                stars.forEach(star => {
                    ctx.fillStyle = `rgba(255, 255, 255, ${star.alpha})`;
                    ctx.beginPath();
                    ctx.arc(star.x, star.y, star.size, 0, Math.PI * 2);
                    ctx.fill();

                    star.alpha += Math.random() * 0.1 - 0.05;
                    if (star.alpha < 0.2) star.alpha = 0.2;
                    if (star.alpha > 1) star.alpha = 1;
                });

                requestAnimationFrame(animate);
            }

            animate();

            window.addEventListener('resize', function() {
                canvas.width = window.innerWidth;
                canvas.height = window.innerHeight;
            });
        }

        // 彩色圆圈效果
        function initCircles() {
            const canvas = document.createElement('canvas');
            canvas.style.position = 'fixed';
            canvas.style.top = '0';
            canvas.style.left = '0';
            canvas.style.zIndex = '-1';
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
            document.body.appendChild(canvas);

            const ctx = canvas.getContext('2d');
            const circles = [];
            const colors = ['#FF6B6B', '#4ECDC4', '#45B7D1', '#96CEB4', '#FFEAA7', '#DDA0DD', '#98D8C8'];

            for (let i = 0; i < 15; i++) {
                circles.push({
                    x: Math.random() * canvas.width,
                    y: Math.random() * canvas.height,
                    radius: Math.random() * 80 + 20,
                    color: colors[Math.floor(Math.random() * colors.length)],
                    speedX: (Math.random() - 0.5) * 2,
                    speedY: (Math.random() - 0.5) * 2,
                    opacity: Math.random() * 0.5 + 0.1
                });
            }

            function animate() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                
                circles.forEach(circle => {
                    circle.x += circle.speedX;
                    circle.y += circle.speedY;
                    
                    if (circle.x < -circle.radius) circle.x = canvas.width + circle.radius;
                    if (circle.x > canvas.width + circle.radius) circle.x = -circle.radius;
                    if (circle.y < -circle.radius) circle.y = canvas.height + circle.radius;
                    if (circle.y > canvas.height + circle.radius) circle.y = -circle.radius;
                    
                    ctx.globalAlpha = circle.opacity;
                    ctx.beginPath();
                    ctx.arc(circle.x, circle.y, circle.radius, 0, Math.PI * 2);
                    ctx.fillStyle = circle.color;
                    ctx.fill();
                });
                
                requestAnimationFrame(animate);
            }
            animate();

            window.addEventListener('resize', () => {
                canvas.width = window.innerWidth;
                canvas.height = window.innerHeight;
            });
        }

        // 矩阵效果
        function initMatrix() {
            const canvas = document.createElement('canvas');
            canvas.style.position = 'fixed';
            canvas.style.top = '0';
            canvas.style.left = '0';
            canvas.style.zIndex = '-1';
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
            document.body.appendChild(canvas);

            const ctx = canvas.getContext('2d');
            const chars = '01アイウエオカキクケコサシスセソタチツテトナニヌネノハヒフヘホマミムメモヤユヨラリルレロワヲン';
            const fontSize = 14;
            const columns = canvas.width / fontSize;
            const drops = [];

            for (let i = 0; i < columns; i++) {
                drops[i] = 1;
            }

            function animate() {
                ctx.fillStyle = 'rgba(0, 0, 0, 0.05)';
                ctx.fillRect(0, 0, canvas.width, canvas.height);
                
                ctx.fillStyle = '#0F3';
                ctx.font = fontSize + 'px monospace';
                
                for (let i = 0; i < drops.length; i++) {
                    const text = chars[Math.floor(Math.random() * chars.length)];
                    ctx.fillText(text, i * fontSize, drops[i] * fontSize);
                    
                    if (drops[i] * fontSize > canvas.height && Math.random() > 0.975) {
                        drops[i] = 0;
                    }
                    drops[i]++;
                }
                
                setTimeout(() => requestAnimationFrame(animate), 100);
            }
            animate();

            window.addEventListener('resize', () => {
                canvas.width = window.innerWidth;
                canvas.height = window.innerHeight;
            });
        }

        // 气泡效果
        function initBubbles() {
            const canvas = document.createElement('canvas');
            canvas.style.position = 'fixed';
            canvas.style.top = '0';
            canvas.style.left = '0';
            canvas.style.zIndex = '-1';
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
            document.body.appendChild(canvas);

            const ctx = canvas.getContext('2d');
            const bubbles = [];

            for (let i = 0; i < 20; i++) {
                bubbles.push({
                    x: Math.random() * canvas.width,
                    y: canvas.height + Math.random() * 100,
                    radius: Math.random() * 30 + 10,
                    speed: Math.random() * 3 + 1,
                    opacity: Math.random() * 0.5 + 0.1,
                    wobble: Math.random() * 0.02 + 0.01
                });
            }

            function animate() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                
                bubbles.forEach(bubble => {
                    bubble.y -= bubble.speed;
                    bubble.x += Math.sin(bubble.y * bubble.wobble) * 0.5;
                    
                    if (bubble.y < -bubble.radius) {
                        bubble.y = canvas.height + bubble.radius;
                        bubble.x = Math.random() * canvas.width;
                    }
                    
                    ctx.globalAlpha = bubble.opacity;
                    ctx.beginPath();
                    ctx.arc(bubble.x, bubble.y, bubble.radius, 0, Math.PI * 2);
                    ctx.strokeStyle = '#87CEEB';
                    ctx.lineWidth = 2;
                    ctx.stroke();
                    
                    const gradient = ctx.createRadialGradient(bubble.x, bubble.y, 0, bubble.x, bubble.y, bubble.radius);
                    gradient.addColorStop(0, 'rgba(135, 206, 235, 0.1)');
                    gradient.addColorStop(1, 'rgba(135, 206, 235, 0)');
                    ctx.fillStyle = gradient;
                    ctx.fill();
                });
                
                requestAnimationFrame(animate);
            }
            animate();

            window.addEventListener('resize', () => {
                canvas.width = window.innerWidth;
                canvas.height = window.innerHeight;
            });
        }

        // 萤火虫效果
        function initFireflies() {
            const canvas = document.createElement('canvas');
            canvas.style.position = 'fixed';
            canvas.style.top = '0';
            canvas.style.left = '0';
            canvas.style.zIndex = '-1';
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
            document.body.appendChild(canvas);

            const ctx = canvas.getContext('2d');
            const fireflies = [];

            for (let i = 0; i < 25; i++) {
                fireflies.push({
                    x: Math.random() * canvas.width,
                    y: Math.random() * canvas.height,
                    radius: Math.random() * 3 + 2,
                    speedX: (Math.random() - 0.5) * 1,
                    speedY: (Math.random() - 0.5) * 1,
                    brightness: Math.random(),
                    pulse: Math.random() * 0.05 + 0.01
                });
            }

            function animate() {
                ctx.fillStyle = 'rgba(0, 0, 0, 0.05)';
                ctx.fillRect(0, 0, canvas.width, canvas.height);
                
                fireflies.forEach(firefly => {
                    firefly.x += firefly.speedX;
                    firefly.y += firefly.speedY;
                    firefly.brightness += firefly.pulse;
                    
                    if (firefly.brightness > 1 || firefly.brightness < 0) {
                        firefly.pulse = -firefly.pulse;
                    }
                    
                    if (firefly.x < 0) firefly.x = canvas.width;
                    if (firefly.x > canvas.width) firefly.x = 0;
                    if (firefly.y < 0) firefly.y = canvas.height;
                    if (firefly.y > canvas.height) firefly.y = 0;
                    
                    const gradient = ctx.createRadialGradient(firefly.x, firefly.y, 0, firefly.x, firefly.y, firefly.radius * 3);
                    gradient.addColorStop(0, `rgba(255, 255, 0, ${firefly.brightness})`);
                    gradient.addColorStop(0.5, `rgba(255, 255, 100, ${firefly.brightness * 0.5})`);
                    gradient.addColorStop(1, 'rgba(255, 255, 0, 0)');
                    
                    ctx.globalAlpha = firefly.brightness;
                    ctx.beginPath();
                    ctx.arc(firefly.x, firefly.y, firefly.radius, 0, Math.PI * 2);
                    ctx.fillStyle = gradient;
                    ctx.fill();
                });
                
                requestAnimationFrame(animate);
            }
            animate();

            window.addEventListener('resize', () => {
                canvas.width = window.innerWidth;
                canvas.height = window.innerHeight;
            });
        }
        <?php endif; ?>

        // 获取网易云热评
        function fetchNetEaseComment() {
            const commentElement = document.getElementById('netEaseComment');
            
            // 显示加载状态
            commentElement.textContent = '加载中...';
            
            // 调用API
            fetch('https://api.yujn.cn/api/wyrp.php')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('网络响应不正常');
                    }
                    return response.text();
                })
                .then(data => {
                    // 处理返回的热评数据
                    commentElement.textContent = data;
                })
                .catch(error => {
                    console.error('获取网易云热评失败:', error);
                    // 出错时显示默认文本
                    commentElement.textContent = '<?php echo htmlspecialchars($site_config['default_comment']); ?>';
                });
        }

        // 天气数据
        const weatherConditions = [
            {
                status: "晴",
                icon: "☀️",
                iconClass: "sun-icon",
                tempRange: [22, 32]
            },
            {
                status: "阴",
                icon: "☁️",
                iconClass: "cloud-icon",
                tempRange: [18, 25]
            },
            {
                status: "雨",
                icon: "🌧️",
                iconClass: "rain-icon",
                tempRange: [15, 22]
            }
        ];

        // 随机天气
        function getRandomWeather() {
            const randomIndex = Math.floor(Math.random() * weatherConditions.length);
            const weather = weatherConditions[randomIndex];
            
            // 随机温度在范围内
            const temp = Math.floor(Math.random() * (weather.tempRange[1] - weather.tempRange[0] + 1)) + weather.tempRange[0];
            
            return {
                ...weather,
                temp: temp
            };
        }
        
        // 更新天气显示
        function updateWeather() {
            const weather = getRandomWeather();
            const weatherEl = document.getElementById('weather');
            const statusEl = weatherEl.querySelector('.weather-status');
            const iconEl = weatherEl.querySelector('.weather-icon');
            const tempEl = weatherEl.querySelector('.weather-temp');
            
            // 添加过渡动画
            iconEl.style.opacity = '0';
            tempEl.style.opacity = '0';
            statusEl.style.opacity = '0';
            
            setTimeout(() => {
                // 移除所有图标类
                iconEl.className = 'weather-icon';
                
                // 添加新图标类
                iconEl.classList.add(weather.iconClass);
                
                // 更新内容
                statusEl.textContent = `天气：${weather.status}`;
                iconEl.textContent = weather.icon;
                tempEl.textContent = `${weather.temp}℃`;
                
                // 淡入新内容
                iconEl.style.opacity = '1';
                tempEl.style.opacity = '1';
                statusEl.style.opacity = '1';
            }, 300);
            
            // 一段时间后再次更新天气
            setTimeout(updateWeather, 300000); // 5分钟更新一次
        }

        // 页面初始化
        document.addEventListener('DOMContentLoaded', () => {
            // 检查本地存储的主题设置
            const savedTheme = localStorage.getItem('darkMode');
            const themeToggle = document.getElementById('themeToggle');
            
            if (savedTheme === 'true') {
                document.body.classList.add('dark-mode');
                themeToggle.classList.add('active');
            }
            
            // 初始化天气
            updateWeather();
            
            // 更新日期时间
            updateDateTime();
            
            // 获取网易云热评
            fetchNetEaseComment();
            
            // 显示主内容
            setTimeout(() => {
                const container = document.getElementById('container');
                container.style.opacity = '1';
                container.style.transform = 'none';
                
                // 显示网站网格
                document.querySelector('.app-grid').style.opacity = '1';
                document.querySelector('.app-grid').style.transform = 'none';
                
                // 显示页脚
                document.querySelector('footer').style.opacity = '1';
                
                // 隐藏加载器
                setTimeout(() => {
                    document.getElementById('loader').classList.add('hidden');
                    
                    // 延迟显示公告弹窗
                    setTimeout(showAnnouncement, 600);
                }, 400);
            }, 400);
            
            // 设置时间更新定时器
            setInterval(updateDateTime, 1000);
            
            // 添加应用点击事件
            setupAppLinks();
            
            // 公告弹窗事件
            const modal = document.getElementById('announcementModal');
            const closeButtons = [
                document.getElementById('closeAnnouncement'),
                document.getElementById('closeAnnouncementBtn')
            ];
            
            closeButtons.forEach(button => {
                button.addEventListener('click', () => {
                    hideAnnouncement();
                    localStorage.setItem('announcementSeenDate', new Date().toISOString().split('T')[0]);
                });
            });
            
            // 点击弹窗背景关闭弹窗
            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    hideAnnouncement();
                    localStorage.setItem('announcementSeenDate', new Date().toISOString().split('T')[0]);
                }
            });
            
            // 模拟访问量
            updateVisitorCount();
            
            // 日夜切换事件
            themeToggle.addEventListener('click', toggleTheme);
            
            // 根据设备类型调整天气显示
            adjustWeatherDisplay();
        });
        
        // 日夜切换功能
        function toggleTheme() {
            const themeToggle = document.getElementById('themeToggle');
            const container = document.getElementById('container');
            const appItems = document.querySelectorAll('.app-item');
            
            // 添加切换动画类
            container.style.transition = 'all 0.5s ease';
            appItems.forEach(item => {
                item.style.transition = 'all 0.5s ease 0.1s';
            });
            
            // 切换主题类
            const isDark = document.body.classList.toggle('dark-mode');
            themeToggle.classList.toggle('active', isDark);
            
            // 保存主题设置
            localStorage.setItem('darkMode', isDark);
            
            // 重置过渡属性
            setTimeout(() => {
                container.style.transition = '';
                appItems.forEach(item => {
                    item.style.transition = '';
                });
            }, 500);
        }
        
        // 更新时间函数
        function updateDateTime() {
            const now = new Date();
            
            // 格式化时间
            const timeStr = now.toLocaleTimeString('zh-CN', {
                hour: '2-digit',
                minute: '2-digit'
            });
            
            // 格式化日期
            const dateOptions = {
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                weekday: 'long'
            };
            const dateStr = now.toLocaleDateString('zh-CN', dateOptions);
            
            // 更新DOM
            document.getElementById('time').textContent = timeStr;
            document.getElementById('date').textContent = dateStr;
        }
        
        // 应用链接配置
        const appLinks = <?php 
            $links = [];
            foreach ($site_config['apps'] as $app) {
                $links[$app['name']] = $app['url'];
            }
            echo json_encode($links);
        ?>;
        
        // 应用点击事件设置
        function setupAppLinks() {
            document.querySelectorAll('.app-item').forEach(item => {
                item.addEventListener('click', function() {
                    this.style.transform = 'scale(0.95)';
                    setTimeout(() => {
                        this.style.transform = '';
                    }, 200);
                    
                    const appName = this.getAttribute('data-app-name');
                    const link = appLinks[appName];
                    
                    if (link) {
                        setTimeout(() => {
                            window.open(link, '_blank');
                        }, 300);
                    }
                });
            });
        }
        
        // 显示公告弹窗
        function showAnnouncement() {
            const lastSeenDate = localStorage.getItem('announcementSeenDate');
            const today = new Date().toISOString().split('T')[0];
            
            if (lastSeenDate !== today) {
                document.getElementById('announcementModal').classList.add('active');
            }
        }
        
        // 隐藏公告弹窗
        function hideAnnouncement() {
            document.getElementById('announcementModal').classList.remove('active');
        }
        
        // 更新访问量计数
        function updateVisitorCount() {
            const countEl = document.getElementById('visitorCount');
            let count = Math.floor(Math.random() * 10000) + 15000;
            countEl.textContent = count.toLocaleString();
            
            setInterval(() => {
                count += Math.floor(Math.random() * 5) + 1;
                countEl.textContent = count.toLocaleString();
            }, 15000);
        }
        
        // 根据设备类型调整天气显示
        function adjustWeatherDisplay() {
            const weatherEl = document.getElementById('weather');
            const statusEl = weatherEl.querySelector('.weather-status');
            
            if (window.innerWidth < 768) {
                statusEl.textContent = ''; // 在小屏幕上只显示图标和温度
            } else {
                // 恢复完整显示
                const currentWeather = weatherEl.querySelector('.weather-status').textContent || '天气：晴';
                statusEl.textContent = currentWeather;
            }
        }
        
        // 监听窗口大小变化
        window.addEventListener('resize', adjustWeatherDisplay);
    </script>
</body>
</html>
