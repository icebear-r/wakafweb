@switch($name)
    @case('education')
        <svg viewBox="0 0 64 64" focusable="false">
            <path d="M4 22 32 10l28 12-28 12L4 22Z"></path>
            <path d="M16 29v12c7 6 25 6 32 0V29L32 36 16 29Z"></path>
            <path d="M55 24v18"></path>
            <circle cx="55" cy="47" r="3"></circle>
        </svg>
        @break

    @case('leaf')
        <svg viewBox="0 0 64 64" focusable="false">
            <path d="M10 45c15 2 35-8 42-34-16 0-30 6-38 18-4 6-5 12-4 16Z"></path>
            <path d="M13 51c10-15 22-25 38-34"></path>
            <path d="M31 50c-4-16-11-24-23-25 1 15 8 23 23 25Z"></path>
        </svg>
        @break

    @case('money')
        <svg viewBox="0 0 64 64" focusable="false">
            <path d="M14 17c0-4 9-7 20-7s20 3 20 7-9 7-20 7-20-3-20-7Z"></path>
            <path d="M14 17v22c0 4 8 7 18 7"></path>
            <path d="M14 28c0 4 8 7 18 7"></path>
            <circle cx="45" cy="40" r="15"></circle>
            <path d="M45 30v20"></path>
            <path d="M51 34c-2-3-11-3-11 2 0 6 11 3 11 9 0 5-9 5-12 1"></path>
        </svg>
        @break

    @case('moon')
        <svg viewBox="0 0 64 64" focusable="false">
            <path d="M44 51A23 23 0 1 1 44 13a20 20 0 1 0 0 38Z"></path>
            <path d="m50 25 3 7 7 1-5 5 1 7-6-3-6 3 1-7-5-5 7-1 3-7Z"></path>
        </svg>
        @break

    @default
        <svg viewBox="0 0 64 64" focusable="false">
            <circle cx="32" cy="14" r="7"></circle>
            <circle cx="17" cy="20" r="6"></circle>
            <circle cx="47" cy="20" r="6"></circle>
            <path d="M23 57V38c0-6 4-10 9-10s9 4 9 10v19"></path>
            <path d="M10 54V38c0-5 3-8 7-8s7 3 7 8"></path>
            <path d="M40 38c0-5 3-8 7-8s7 3 7 8v16"></path>
            <path d="M31 28h2"></path>
        </svg>
@endswitch
