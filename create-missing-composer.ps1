$pluginsPath = "c:\tic.ci\ticci360\platform\plugins"
$missingPlugins = @("ads", "audit-log", "backup", "blog", "captcha", "contact", "cookie-consent", "faq", "language", "language-advanced", "marketplace", "newsletter", "paypal-payout", "request-log", "simple-slider", "sslcommerz", "stripe-connect", "testimonial")

foreach ($pluginName in $missingPlugins) {
    $pluginPath = Join-Path $pluginsPath $pluginName
    $composerFile = Join-Path $pluginPath "composer.json"
    
    # Convert plugin name to namespace
    $namespace = ($pluginName -split '-' | ForEach-Object { 
        (Get-Culture).TextInfo.ToTitleCase($_) 
    }) -join ''
    
    $json = @{
        name = "botble/$pluginName"
        description = "Botble $namespace plugin"
        type = "package"
        autoload = @{
            "psr-4" = @{
                "Botble\$namespace\" = "src/"
            }
        }
    }
    
    $json | ConvertTo-Json -Depth 10 | Set-Content $composerFile -Encoding UTF8
    Write-Host "CREATED: $pluginName -> Botble\$namespace\" -ForegroundColor Green
}

Write-Host "`nDone!" -ForegroundColor Cyan
