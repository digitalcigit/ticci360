$pluginsPath = "c:\tic.ci\ticci360\platform\plugins"
$plugins = Get-ChildItem $pluginsPath -Directory

foreach ($plugin in $plugins) {
    $composerFile = Join-Path $plugin.FullName "composer.json"
    if (Test-Path $composerFile) {
        $json = Get-Content $composerFile -Raw | ConvertFrom-Json
        
        # Skip if autoload already exists
        if ($json.autoload) {
            Write-Host "SKIP: $($plugin.Name) - autoload exists" -ForegroundColor Yellow
            continue
        }
        
        # Convert plugin name to namespace (kebab-case to PascalCase)
        $namespace = ($plugin.Name -split '-' | ForEach-Object { 
            (Get-Culture).TextInfo.ToTitleCase($_) 
        }) -join ''
        
        # Add autoload section
        $autoload = @{
            "psr-4" = @{
                "Botble\$namespace\" = "src/"
            }
        }
        $json | Add-Member -NotePropertyName "autoload" -NotePropertyValue $autoload -Force
        
        # Save
        $json | ConvertTo-Json -Depth 10 | Set-Content $composerFile -Encoding UTF8
        Write-Host "UPDATED: $($plugin.Name) -> Botble\$namespace\" -ForegroundColor Green
    }
}

Write-Host "`nDone! Run 'composer dump-autoload' next." -ForegroundColor Cyan
